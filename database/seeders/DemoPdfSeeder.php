<?php

namespace Database\Seeders;

use App\Models\Pdfdoc;
use App\Models\TextData;
use App\Models\TextVector;
use Illuminate\Database\Seeder;

class DemoPdfSeeder extends Seeder
{
    public function run(): void
    {
        $pdf = Pdfdoc::firstOrCreate([
            'name' => 'Frendo AI Demo Notes',
        ], [
            'file' => 'demo/frendo-ai-demo-notes.pdf',
        ]);

        $chunks = [
            'Frendo pilot AI feature: optional user check-ins can capture missed work, stress, relationship impact, mental health strain and financial pressure alongside symptom tracking data.',
            'The MVP should identify simple non-medical patterns such as pain or fatigue aligning with missed work, stress, or relationship impact. The output should be framed as reflection and support only.',
            'Pre-approved prompts can suggest supportive actions such as checking in with a trusted support person, reviewing patterns before an appointment, or taking a moment to reflect. The system must not provide diagnosis, treatment advice, or medical recommendations.',
        ];

        foreach ($chunks as $chunk) {
            $text = TextData::firstOrCreate([
                'file_id' => $pdf->id,
                'text' => $chunk,
            ]);

            TextVector::updateOrCreate([
                'file_id' => $pdf->id,
                'text_id' => $text->id,
            ], [
                'vector' => json_encode($this->localEmbedding($chunk)),
            ]);
        }
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
