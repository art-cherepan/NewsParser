<?php

namespace App\Controller;

use App\Entity\News;
use App\Repository\NewsRepository;
use App\Serializer\Normalizer\NewsNormalizer;
use App\Serializer\Normalizer\NewsRatingNormalizer;
use App\Services\NewsResolver;
use App\Services\ParseContentByFile;
use App\Services\ParseContentByUrl;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/news")
 */
class NewsController extends AbstractController
{
    private NewsRepository $newsRepository;

    public function __construct(NewsRepository $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }

    /**
     * @Route("/", name="api_news")
     */
    public function ApiNews(Request $request): Response
    {
        $index = $request->query->get('index');
        $count = $request->query->get('count');

        $resolver = new NewsResolver($this->newsRepository);
        $news = $resolver->getNews($index, $count);

        $normalizer = new NewsNormalizer();

        $data = $normalizer->getNormalizedData($news, $count);

        return new JsonResponse($data);
    }

    /**
     * @Route("/get-rating/", name="api_get_news_rating")
     */
    public function ApiGetNewsRating(): Response
    {
        $ratings = $this->newsRepository->findRatingForAll();
        $normalizer = new NewsRatingNormalizer();

        return new JsonResponse($normalizer->normalize($ratings));
    }

    /**
     * @Route("/{news}/{rating}/update-rating/", name="api_update_news_rating")
     */
    public function ApiUpdateNewsRating(News $news, int $rating): Response
    {
        $news->setRating($rating);
        $this->newsRepository->save($news);

        return new Response();
    }

    /**
     * @Route("/create/", name="create_news")
     */
    public function create(Request $request): Response
    {
        $id = $request->query->get('id');
        $title = $request->query->get('title');
        $text = $request->query->get('text');

        $news = new News();

        $news->setId(intval($id));
        $news->setTitle($title);
        $news->setText($text);
        $news->setRating(rand(1, 10));

        $this->newsRepository->save($news);

        return new Response();
    }

    /**
     * @Route("/remove/", name="remove_news")
     */
    public function remove(Request $request): Response
    {
        $id = $request->query->get('id');

        $news = $this->newsRepository->findOneBy(['id' => $id]);
        assert($news instanceof News);

        $this->newsRepository->remove($news);

        return new Response();
    }
}
