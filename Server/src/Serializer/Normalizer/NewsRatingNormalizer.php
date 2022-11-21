<?php

namespace App\Serializer\Normalizer;

class NewsRatingNormalizer
{
    public function normalize(array $arr)
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
