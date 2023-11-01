<?php

namespace App\Services;

use App\Helpers\CrawlerHelper;

abstract class AbstractContentParser
{
    protected CrawlerHelper $crawlerHelper;
    abstract protected function getNews();

    public function __construct(CrawlerHelper $crawlerHelper)
    {
        $this->crawlerHelper = $crawlerHelper;
    }
}
