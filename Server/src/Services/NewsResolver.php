<?php

namespace App\Services;

use App\Entity\News;
use App\Repository\NewsRepository;

class NewsResolver
{
    private NewsRepository $newsRepository;

    public function __construct(NewsRepository $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }

    /**
     * @return array<News>
     */
    public function getNews(int $index, int $count): array
    {
        if ($index === 0) {
            $news = $this->newsRepository->findFirstByCount($count);
        } else {
            $news = $this->newsRepository->findByStartIdAndCount($index, $count);
        }

        return $news;
    }
}
