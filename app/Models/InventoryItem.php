<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class InventoryItem extends Model
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
    public function variant() {
        return $this->belongsTo(
            ProductVariant::class,
            'product_variant_id'
        );
    }

    public function outlet() {
        return $this->belongsTo(Outlet::class);
    }

    public function logs()
    {
        return $this->hasMany(InventoryLog::class);
    }
}
