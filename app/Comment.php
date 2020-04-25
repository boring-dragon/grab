<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'source',
        'author_name',
        'comment',
        'upvotes',
        'downvotes',
        'date',
        'comment_id',
        'post_id'
    ];
}
