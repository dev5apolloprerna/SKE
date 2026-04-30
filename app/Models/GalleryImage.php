<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    protected $fillable = ['title','image_url','description','sort_order','is_active'];
    protected $casts = ['is_active' => 'boolean'];

    public function getUrlAttribute(): string
    {
        if ($this->image_url && file_exists(public_path($this->image_url))) {
            return asset($this->image_url);
        }
        return asset('images/default-product.jpg');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1)->orderBy('sort_order');
    }
}
