<?php

namespace App\Serializer\Normalizer;

use App\Entity\News;

class NewsNormalizer
{
    public function getNormalizedData($news, $count): array
    {
        $data = [];

        foreach ($news as $article) {
            $articleNormalized = $this->normalize($article);
            $data['data'][] = $articleNormalized;
        }

        if (count($data['data']) < $count) {
            $data['lastDataPortion'] = true;
        } else {
            $data['lastDataPortion'] = false;
        }

        return $data;
    }

    private function normalize($object)
    {
        if (!$object instanceof News) {
            throw new \Exception('Object for normalize must be a News entity');
        }

        return [
            'id' => $object->getId(),
            'title' => $object->getTitle(),
            'text' => mb_substr($object->getText(), 0, 200),
            'rating' => $object->getRating(),
            'imageHtml' => $object->getImageHtml(),
        ];
    }
}
