<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'price', 'published_at', 'status', 'user_id'];
    protected $hidden = ['created_at', 'updated_at'];
    protected $dates = ['published_at'];

    public function scopePublished($query)
    {
        return $query->where('published_at', '<=', Carbon::now());
    }

    public function scopeQ($query, $q)
    {
        return $query->where('name', 'like', '%' . $q . '%');
    }
}
