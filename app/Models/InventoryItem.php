<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class InventoryItem extends Model
{
    use HasUuids;

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
     * Fungsi ketika model Eloquent selesai dimuat.
     *
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }


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
