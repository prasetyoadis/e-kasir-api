<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasUlids;

    /**
     * The attributes that are mass protecable.
     *
     * @var list<string>
     */
    protected $guarded = ['id'];
    protected $keyType = 'string';

    /**
     * The attributes that are mass public.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Relation Model
     * 
     * 
     */
    public function variants() {
        return $this->hasMany(ProductVariant::class);
    }
    public function images() {
        return $this->hasMany(ProductImage::class);
    }
    public function categories() {
        return $this->belongsToMany(
            Category::class, 
            'category_product', 
            'product_id', 
            'category_id'
        )->withTimestamps();
    }
    // Optional (kalau sering butuh stok by product)
    public function inventoryItems() {
        return $this->hasManyThrough(
            InventoryItem::class,
            ProductVariant::class,
            'product_id',         // FK di product_variants
            'product_variant_id', // FK di inventory_items
            'id',
            'id'
        );
    }
    
}
