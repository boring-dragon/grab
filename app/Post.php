<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'source',
        'post_id',
        'title',
        'date',
        'content',
        'link',
    ];
}
