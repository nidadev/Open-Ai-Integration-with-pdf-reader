<?php

namespace App\Services;

use App\Models\TextVector;
use App\Models\TextData;

class VectorService
{
    public function getTextsFromIds(array $ids): array
    {
        $texts = TextData::whereIn('id', $ids)->get()->keyBy('id');

        return collect($ids)
            ->map(fn ($id) => optional($texts->get($id))->text)
            ->filter()
            ->values()
            ->all();
    }

    public function getMostSimilarVectors(array $vector, int $fileId, int $limit = 10): array
    {
        $vectors = TextVector::where('file_id', $fileId)
            ->get()
            ->map(function ($vector) {
                return [
                    'id' => $vector->id,
                    'text_id' => $vector->text_id,
                    'vector' => json_decode($vector->vector, true)
                ];
            })
            ->toArray();

        $similarVectors = [];
        foreach ($vectors as $v) {
            $cosineSimilarity = $this->calculateCosineSimilarity($vector, $v['vector']);
            $similarVectors[] = [
                'id' => $v['id'],
                'text_id' => $v['text_id'],
                'similarity' => $cosineSimilarity
            ];
        }

        usort($similarVectors, function ($a, $b) {
            return $b['similarity'] <=> $a['similarity'];
        });

        return array_slice($similarVectors, 0, $limit);
    }

    private function calculateCosineSimilarity(array $v1, array $v2): float
    {
        $dotProduct = 0;
        $v1Norm = 0;
        $v2Norm = 0;

        foreach ($v1 as $i => $value) {
            $other = $v2[$i] ?? 0;
            $dotProduct += $value * $other;
            $v1Norm += $value * $value;
            $v2Norm += $other * $other;
        }

        $v1Norm = sqrt($v1Norm);
        $v2Norm = sqrt($v2Norm);

        if ($v1Norm == 0.0 || $v2Norm == 0.0) {
            return 0.0;
        }

        return $dotProduct / ($v1Norm * $v2Norm);
    }
}
