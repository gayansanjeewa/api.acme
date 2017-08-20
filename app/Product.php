<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $hidden = ['created_at', 'updated_at'];
    protected $dates = ['published_at'];

    public function scopePublished($query)
    {
        return $query->where('published_at', '<=', Carbon::now());
    }
}
