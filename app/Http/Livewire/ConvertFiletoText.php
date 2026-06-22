<?php

namespace App\Http\Livewire;

use App\Models\Pdfdoc;
use App\Services\VectorService;
use Livewire\Component;
use OpenAI\Laravel\Facades\OpenAI;

class ConvertFiletoText extends Component
{
    public $document, $convertedText, $input, $answer;

    protected $rules = [
        'document' => 'required',
        'input' => 'required'
    ];

    public function convertFile()
    {
        $this->validate();
        $pdf_file = Pdfdoc::find($this->document);

        if (!$pdf_file) {
            $this->addError('document', 'Selected PDF was not found.');
            return;
        }

        try {           
            $queryVector = $this->embeddingFor($this->input);
            $vectorService = new VectorService();
            $relevantChunks = $vectorService->getMostSimilarVectors($queryVector, $pdf_file->id, 4);
            $similarTexts = $vectorService->getTextsFromIds(array_column($relevantChunks, 'text_id'));
            $knowledgeBase = trim(implode("\n\n", $similarTexts));

            if ($knowledgeBase === '') {
                $this->answer = 'I could not find enough text in this PDF to answer that question.';
                return;
            }

            $this->answer = $this->answerQuestion($this->input, $knowledgeBase);
        } catch (\Throwable $th) {
            report($th);
            $this->answer = 'Something went wrong while searching this PDF: ' . $th->getMessage();
        }
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

    private function answerQuestion(string $question, string $knowledgeBase): string
    {
        if (config('openai.api_key')) {
            try {
                $prompt = "Answer the user's question using only the source text below. "
                    . "If the answer is not present, say: Sorry, I do not know.\n\n"
                    . "Question: {$question}\n\nSource text:\n{$knowledgeBase}";

                $response = OpenAI::completions()->create([
                    'model' => 'gpt-3.5-turbo-instruct',
                    'prompt' => $prompt,
                    'max_tokens' => 700,
                ]);

                return trim($response['choices'][0]['text'] ?? '');
            } catch (\Throwable $exception) {
                report($exception);
            }
        }

        return "Based on the PDF, the most relevant information I found is:\n\n"
            . mb_substr($knowledgeBase, 0, 1200);
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
        $docs = Pdfdoc::all();
        return view('livewire.convert-fileto-text', ['docs' => $docs])->extends('layouts.app')->section('content');
    }
}
