<?php

namespace App\Tranformers;

interface ITranformer
{
    public static function tranform(array $item): array;
}
