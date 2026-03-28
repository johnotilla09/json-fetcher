<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = [
        'id',
        'albumId',
        'title',
        'url',
        'thumbnail_url'
    ];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }
}
