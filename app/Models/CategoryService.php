<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CategoryService extends Model
{
    use HasFactory;

    protected $table = 'category_service';

    protected $fillable = [
        'title',
        'description',
        'slug'
    ];

    /**
     * Boot method untuk auto-generate slug sebelum create
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug) && !empty($category->title)) {
                $category->slug = Str::slug($category->title);
            }
        });
    }

    /**
     * Relasi ke Service (one-to-many)
     */
    public function services()
    {
        return $this->hasMany(Service::class, 'category_id'); // pastikan foreign key di Service
    }
}