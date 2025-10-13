<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $table = 'portofolio';
    protected $fillable = ['title', 'url', 'image'];
}
