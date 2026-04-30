<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'subcategory_id',
        'model_no',
        'name',
        'slug',
        'short_description',
        'long_description',
        'length_mm',
        'width_mm',
        'height_mm',
        'specifications',
        'source_page',
        'seo_title',
        'seo_description',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'is_featured'    => 'boolean',
        'is_active'      => 'boolean',
        'specifications' => 'array',
        'length_mm'      => 'float',
        'width_mm'       => 'float',
        'height_mm'      => 'float',
    ];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order', 'asc');
    }

        public function primaryImage()
    {
        return $this->hasOne(ProductImage::class, 'product_id', 'id')
            ->where('is_primary', 1);
    }


    /** Dimension string e.g. 300 × 200 × 100 mm */
    public function getDimensionsAttribute(): string
    {
        $parts = array_filter([$this->length_mm, $this->width_mm, $this->height_mm]);
        if (empty($parts)) return '—';
        return implode(' × ', array_map(fn($v) => (int)$v, $parts)) . ' mm';
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', 1)->where('is_active', 1);
    }
}