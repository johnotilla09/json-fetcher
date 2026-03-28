<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'id',
        'postId',
        'name',
        'email',
        'body'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class, 'postId', 'id');
    }
}
