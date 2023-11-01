<?php

namespace App\Helpers;

use Exception;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;

class CrawlerHelper
{
    private const NEWS_SITE_URL = 'https://www.rbc.ru/';
    private const HTML_EXTERNAL_SOURCE_CONTENT = __DIR__ . '/../../content/rbcContent.html';

    public function getCrawlerUrl(): Crawler
    {
        $client = HttpClient::create();
        $response = $client->request('GET', self::NEWS_SITE_URL);
        $statusCode = $response->getStatusCode();

        if ($statusCode !== 200) {
            throw new Exception('Response status is not 200');
        }

        return new Crawler($response->getContent());
    }

    public function getCrawlerFile(): Crawler
    {
        $html = file_get_contents(self::HTML_EXTERNAL_SOURCE_CONTENT);

        return new Crawler($html);
    }
}
