<?php

namespace App\Http\Livewire;

use App\Models\Pdfdoc;
use App\Models\TextData;
use App\Models\TextVector;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use OpenAI\Laravel\Facades\OpenAI;

class PdfToTextComponent extends Component
{
    use WithFileUploads;
    public $pdf_doc, $convertedText;

    protected $rules = [
        'pdf_doc' => ['required','mimes:pdf'],
    ];

    public function getFile()
    {
        $this->validate();
        $file_name = now()->format('YmdHis') . '.' . $this->pdf_doc->getClientOriginalExtension();
        $file = $this->pdf_doc->storePubliclyAs('pdf-file', $file_name, 'public');
        $pdf_file = Pdfdoc::create([
            'name' => $file_name,
            'file' => $file,
        ]);

        // Convert PDF to text.
        $pdf_path = Storage::disk('public')->path($file);
        $parser = new \Smalot\PdfParser\Parser();
        $pdf = $parser->parseFile($pdf_path);
        $pdf_text = $pdf->getText();
        $cleanedText = $this->cleanText($pdf_text);

        $this->convertedText = $cleanedText;

        $chunks = $this->chunkText($cleanedText);
        $chunkCount = count($chunks);

        foreach ($chunks as $a => $chunk) {
            $context = '';
            if ($a > 0) {
                $prevChunk = $chunks[$a - 1];
                $context = implode(' ', array_slice(explode(' ', $prevChunk), -$overlapWords));
            }
            if ($a < $chunkCount - 1) {
                $nextChunk = $chunks[$a + 1];
                $context .= ' ' . implode(' ', array_slice(explode(' ', $nextChunk), 0, $overlapWords));
            }

            $chunkWithContext = $context . ' ' . $chunk;
            $vector = $this->embeddingFor($chunkWithContext);

            $textData = TextData::firstOrCreate([
                'file_id' => $pdf_file->id,
                'text' => $chunkWithContext,
            ]);

            TextVector::create([
                'text_id' => $textData->id,
                'vector' => json_encode($vector),
                'file_id' => $pdf_file->id,
            ]);
        }

        $this->reset('pdf_doc');
        session()->flash('message', 'File created & converted Successfully');
    }

    private function cleanText(string $text): string
    {
        $text = Str::of($text)
            ->replaceMatches('/[^\P{C}\n\t]+/u', ' ')
            ->replaceMatches('/\s+/', ' ')
            ->trim();

        return (string) $text;
    }

    private function chunkText(string $text, int $wordsPerChunk = 450, int $overlapWords = 80): array
    {
        $words = preg_split('/\s+/', $text, -1, PREG_SPLIT_NO_EMPTY);
        if (!$words) {
            return [];
        }

        $chunks = [];
        $step = max(1, $wordsPerChunk - $overlapWords);

        for ($start = 0; $start < count($words); $start += $step) {
            $chunks[] = implode(' ', array_slice($words, $start, $wordsPerChunk));
        }

        return $chunks;
    }

    private function embeddingFor(string $text): array
    {
        if (config('openai.api_key')) {
            $vector = OpenAI::embeddings()->create([
                'model' => 'text-embedding-ada-002',
                'input' => $text,
            ]);

            return $vector['data'][0]['embedding'];
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

    public function render()
    {
        return view('livewire.pdf-to-text-component')->extends('layouts.app')->section('content');
    }
}
