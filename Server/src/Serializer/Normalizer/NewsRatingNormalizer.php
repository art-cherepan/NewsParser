<?php

namespace App\Serializer\Normalizer;

class NewsRatingNormalizer implements NormalizerInterface
{
    public function normalize($arr, $count = 0): array
    {
        $ratings = [];

        foreach ($arr as $item => $value) {
            $ratings[] = [
                'id' => $value['id'],
                'rating' => $value['rating'],
            ];
        }

        return $ratings;
    }
}
