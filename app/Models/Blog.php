<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'thumbnail',
        'body',
        'user_id',
        'status',
    ];

    /**
     * The categories that belong to the blog.
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'blog_category');
    }

    /**
     * The tags that belong to the blog.
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'blog_tag');
    }

    /**
     * The user that owns the blog.
     */
    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
