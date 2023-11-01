<?php

namespace App\Controller;

use App\Repository\NewsRepository;
use App\Services\ContentParserByFile;
use App\Services\ContentParserByUrl;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/content")
 */
class NewsParserController extends AbstractController
{
    private NewsRepository $newsRepository;

    public function __construct(NewsRepository $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }

    /**
     * @Route("/save-by-file/", name="news_save_by_file")
     */
    public function saveByFile(ContentParserByFile $contentParser): Response
    {
        $news = $contentParser->getNews();

        foreach ($news as $article) {
            $this->newsRepository->save($article);
        }

        return new Response();
    }

    /**
     * @Route("/save-by-url/", name="save_by_url")
     */
    public function saveByUrl(ContentParserByUrl $contentParser): Response
    {
        $news = $contentParser->getNews();

        foreach ($news as $article) {
            $this->newsRepository->save($article);
        }

        return new Response();
    }
}
