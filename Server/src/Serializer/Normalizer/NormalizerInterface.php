<?php

namespace App\Serializer\Normalizer;

interface NormalizerInterface
{
    public function normalize($objects, $count = 0): array;
}
