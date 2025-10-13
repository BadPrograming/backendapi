<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['title', 'description'];

    public function category()
{
    return $this->belongsTo(CategoryService::class, 'category_id');
}

}