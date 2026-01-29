<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Category extends Model
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
    public function products() {
        return $this->belongsToMany(
            Category::class, 
            'category_product', 
            'category_id', 
            'product_id'
        )->withTimestamps();
    }

    public function outlet() {
        return $this->belongsTo(Outlet::class);
    }
}
