<?php

namespace App\Services;

use App\Models\Pdfdoc;
use App\Models\TextData;
use App\Models\TextVector;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use OpenAI\Laravel\Facades\OpenAI;
use Smalot\PdfParser\Parser;

class PdfIngestionService
{
    public function ingest(UploadedFile $uploadedFile): array
    {
        $fileName = now()->format('YmdHis') . '-' . Str::slug(pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME)) . '.pdf';
        $file = $uploadedFile->storePubliclyAs('pdf-file', $fileName, 'public');

        $pdfFile = Pdfdoc::create([
            'name' => $fileName,
            'file' => $file,
        ]);

        $pdfPath = Storage::disk('public')->path($file);
        $pdf = (new Parser())->parseFile($pdfPath);
        $cleanedText = $this->cleanText($pdf->getText());

        foreach ($this->chunkText($cleanedText) as $chunkWithContext) {
            $textData = TextData::firstOrCreate([
                'file_id' => $pdfFile->id,
                'text' => $chunkWithContext,
            ]);

            TextVector::create([
                'text_id' => $textData->id,
                'vector' => json_encode($this->embeddingFor($chunkWithContext)),
                'file_id' => $pdfFile->id,
            ]);
        }

        return [
            'pdf' => $pdfFile,
            'text' => $cleanedText,
        ];
    }

    private function cleanText(string $text): string
    {
        return (string) Str::of($text)
            ->replaceMatches('/[^\P{C}\n\t]+/u', ' ')
            ->replaceMatches('/\s+/', ' ')
            ->trim();
    }

    private function chunkText(string $text, int $wordsPerChunk = 450, int $overlapWords = 80): array
    {
        $words = preg_split('/\s+/', $text, -1, PREG_SPLIT_NO_EMPTY);
        if (!$words) {
            return [];
        }

        $chunks = [];
        $step = max(1, $wordsPerChunk - $overlapWords);
        $wordCount = count($words);

        for ($start = 0; $start < $wordCount; $start += $step) {
            $from = max(0, $start - $overlapWords);
            $length = min($wordsPerChunk + $overlapWords, $wordCount - $from);
            $chunks[] = implode(' ', array_slice($words, $from, $length));
        }

        return $chunks;
    }

    private function embeddingFor(string $text): array
    {
        if (config('openai.api_key')) {
            try {
                $vector = OpenAI::embeddings()->create([
                    'model' => 'text-embedding-ada-002',
                    'input' => $text,
                ]);

                return $vector['data'][0]['embedding'];
            } catch (\Throwable $exception) {
                report($exception);
            }
        }

        return $this->localEmbedding($text);
    }

    private function localEmbedding(string $text, int $dimensions = 256): array
    {
        $vector = array_fill(0, $dimensions, 0.0);
        $words = preg_split('/[^a-z0-9]+/i', strtolower($text), -1, PREG_SPLIT_NO_EMPTY);

        foreach ($words as $word) {
            $index = abs(crc32($word)) % $dimensions;
            $vector[$index] += 1.0;
        }

        return $vector;
    }
}
