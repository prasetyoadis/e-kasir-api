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
        return $this->belongsToMany(Subscription::class, 'outlet_subscription', 'outlet_id', 'subscription_id');
    }
    public function owner() {
        return $this->belongsTo(User::class);
    }

}
