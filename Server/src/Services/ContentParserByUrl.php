<?php

namespace App\Services;

use App\Entity\News;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;

class ContentParserByUrl extends AbstractContentParser
{
    /**
     * @return array<News>
     */
    public function getNews(): array
    {
        $articleLinks = $this->crawlerHelper->getCrawlerUrl()
            ->filter('.js-news-feed-list')
            ->filter('a[href]')
            ->each(function (Crawler $node) {
                if (str_starts_with($node->attr('href'), 'https://www.rbc.ru/')) {
                    return $node->attr('href');
                }
            });

        $articleLinks = array_filter($articleLinks);

        $news = [];

        foreach ($articleLinks as $articleLink) {
            $article = new News();
            $response = HttpClient::create()->request('GET', $articleLink);

            $crawler = new Crawler($response->getContent());

            $article->setTitle($crawler->filter('h1')->text());
            $article->setText($crawler->filter('.article__text')->text());

            $crawlerImage = ($crawler->filter('.article__main-image__wrap'));
            if ($crawlerImage->count() > 0) {
                $article->setImageHtml($crawler->filter('.article__main-image__wrap')->html());
            }

            $article->setRating(rand(1, 10));

            $news[] = $article;

        }

        return $news;
    }
}
