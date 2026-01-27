<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Outlet extends Model
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
    */
    public function subscriptions() {
        return $this->belongsToMany(
            Subscription::class, 
            'outlet_subscription', 
            'outlet_id', 
            'subscription_id'
        )->withTimestamps();
    }
    public function owner() {
        return $this->belongsTo(User::class);
    }
    public function employees() {
        return $this->belongsToMany(
            User::class,
            'outlet_user',
            'outlet_id',
            'user_id'
        )
        ->using(OutletUser::class)->withPivot('role_id')->withTimestamps();
    }
    public function categories() {
        return $this->hasMany(Category::class);
    }
    public function inventories() {
        return $this->hasMany(InventoryItem::class);
    }
    public function Invenlogs() {
        return $this->hasMany(InventoryLog::class);
    }
}
