<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'body', 'cover_image', 'pinned', 'deleted_at', 'user_id'];

    public function tags()
    {
        return $this->belongsToMany(
            Tag::class, 
            PostTag::class, 
            'post_id', 
            'tag_id', 
            'id', 
            'id'
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
