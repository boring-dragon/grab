<?php

namespace App\Tranformers;

use Illuminate\Support\Arr;

class PostTranformer implements ITranformer
{
    // Conditional posts keys
    protected static $posts_keys = [
        'id',
        'date',
        'content',
        'title',
        'link',
        'content',
    ];

    /**
     * tranform.
     *
     *  Tranforms Posts
     *
     * @param mixed $post
     *
     * @return array
     */
    public static function tranform(array $post): array
    {
        foreach (self::$posts_keys as $key) {
            if (!Arr::exists($post, $key)) {
                $post[$key] = null;
            }
        }

        return $post;
    }
}
