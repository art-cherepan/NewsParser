<?php

namespace App\Serializer\Normalizer;

use App\Entity\News;

class NewsNormalizer implements NormalizerInterface
{
    public function normalize($news, $count = 0): array
    {
        $data = [];

        foreach ($news as $article) {
            if (!$article instanceof News) {
                throw new \Exception('Object for normalize must be a News entity');
            }

            $articleNormalized = [
                'id' => $article->getId(),
                'title' => $article->getTitle(),
                'text' => mb_substr($article->getText(), 0, 200),
                'rating' => $article->getRating(),
                'imageHtml' => $article->getImageHtml(),
            ];

            $data['data'][] = $articleNormalized;
        }

        if (count($data['data']) < $count) {
            $data['lastDataPortion'] = true;
        } else {
            $data['lastDataPortion'] = false;
        }

        return $data;
    }
}
