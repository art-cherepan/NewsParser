<?php

namespace App\Services;

use App\Entity\News;
use Symfony\Component\DomCrawler\Crawler;

class ParseContentByFile
{
    /**
     * @return array<News>
     */
    public function getNewsFromSource(): array
    {
        $html = file_get_contents(__DIR__ . '/../../content/rbcContent.html');
        $crawler = new Crawler($html);

        $articleLinks = $crawler
            ->filter('.js-news-feed-list')
            ->filter('a[href]')
            ->each(function(Crawler $node) {
                if (str_starts_with($node->attr('href'), 'https://www.rbc.ru/')) {
                    return $node->attr('href');
                }
            });

        $articleLinks = array_filter($articleLinks);

        $news = [];
        $index = 0;

        foreach ($articleLinks as $articleLink) {
            $article = new News();
            $response = file_get_contents(__DIR__ . '/../../content/news_' . $index . '_content.html');

            $crawler = new Crawler($response);

            $article->setTitle($crawler->filter('h1')->text());
            $article->setText($crawler->filter('.article__text')->text());

            $crawlerImage = ($crawler->filter('.article__main-image__wrap'));
            if ($crawlerImage->count() > 0) {
                $article->setImageHtml(explode(' ', $crawler->filter('.article__main-image__wrap')->filter('.smart-image')->filter('source')->attr('srcset'))[0]);
            }

            $article->setRating(rand(1,10));

            $news[] = $article;

            ++$index;
        }

        return $news;
    }
}

