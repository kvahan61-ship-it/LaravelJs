<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id', 'post_id', 'quantity'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
