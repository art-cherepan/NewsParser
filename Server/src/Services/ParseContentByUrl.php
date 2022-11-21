<?php

namespace App\Services;

use App\Entity\News;
use Exception;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ParseContentByUrl
{
    private const NEWS_SITE_URL = 'https://www.rbc.ru/';

    private HttpClientInterface $client;

    public function __construct()
    {
        $this->client = HttpClient::create();
    }

    /**
     * @return array<News>
     */
    public function getNewsFromSource(): array
    {
        $response = $this->client->request('GET', self::NEWS_SITE_URL);
        $statusCode = $response->getStatusCode();

        if ($statusCode !== 200) {
            throw new Exception('Response status is not 200');
        }

        $crawler = new Crawler($response->getContent());

        $articleLinks = $crawler
            ->filter('.js-news-feed-list')
            ->filter('a[href]')
            ->each(function (Crawler $node) {
                if (str_starts_with($node->attr('href'), 'https://www.rbc.ru/')) {
                    return $node->attr('href');
                }
            });

        $articleLinks = array_filter($articleLinks);

        $news = [];
        $index = 1;

        foreach ($articleLinks as $articleLink) {
            $article = new News();
            $response = $this->client->request('GET', $articleLink);

            $crawler = new Crawler($response->getContent());

            $article->setTitle($crawler->filter('h1')->text());
            $article->setText($crawler->filter('.article__text')->text());

            $crawlerImage = ($crawler->filter('.article__main-image__wrap'));
            if ($crawlerImage->count() > 0) {
                $article->setImageHtml($crawler->filter('.article__main-image__wrap')->html());
            }

            $article->setRating(rand(1, 10));

            $news[] = $article;

            ++$index;
        }

        return $news;
    }
}

