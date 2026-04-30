<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends Model
{
    public $timestamps = false;
    protected $fillable = ['product_id','image_url','alt_text','sort_order'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getUrlAttribute(): string
    {
        if ($this->image_url && file_exists(public_path($this->image_url))) {
            return asset($this->image_url);
        }
        return asset('images/default-product.jpg');
    }
}
