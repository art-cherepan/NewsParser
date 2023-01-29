<?php

namespace App\Services;

abstract class ContentParser
{
    abstract protected function getCrawlerFromSource();
    abstract protected function getNews();
}
