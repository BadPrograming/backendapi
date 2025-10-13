<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    use HasFactory;

    protected $table = 'career';

    protected $fillable = [
        'title',
        'description',
        'category_id',
    ];

    // Relasi ke CategoryCareer
    public function category()
    {
        return $this->belongsTo(CategoryCareer::class, 'category_id');
    }
}