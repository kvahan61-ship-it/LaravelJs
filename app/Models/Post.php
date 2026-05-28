<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;


    protected $fillable = [
        'title',
        'category_id',
        'price',
        'description',
        'user_id',
    ];


    public function images()
    {
        return $this->hasMany(PostImage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function postViews(): HasMany
    {
        return $this->hasMany(PostView::class);
    }
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
