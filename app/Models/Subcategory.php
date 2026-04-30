<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'sort_order',
        'is_active',
    ];

    public $timestamps = false;
    protected $casts = ['is_active' => 'boolean'];


    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1)->orderBy('sort_order');
    }
}