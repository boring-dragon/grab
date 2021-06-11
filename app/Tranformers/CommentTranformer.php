<?php

namespace App\Tranformers;

use Illuminate\Support\Arr;

class CommentTranformer implements ITranformer
{ // Conditional comment keys
    protected static $comment_keys = [
        'id',
        'post',
        'author_name',
        'content',
        'comment',
        'upvotes',
        'downvotes',
        'date',
        'timestamp',
    ];

    /**
     * tranform.
     *
     *  Tranforms comments
     *
     * @param mixed $comment
     *
     * @return array
     */
    public static function tranform(array $comment): array
    {
        foreach (self::$comment_keys as $key) {
            if (!Arr::exists($comment, $key)) {
                $comment[$key] = null;
            }
        }

        return $comment;
    }
}
