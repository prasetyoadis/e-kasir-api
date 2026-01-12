<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Role extends Model
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
     * @var list<string>
     */
    public $incrementing = false;

    /**
     * Function to set route key name.
     *
     * @return string
     */
    public function getRouteKeyName(){
        return 'slug';
    }


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
    public function users() {
        return $this->belongsToMany(User::class, 'role_user', 'role_id', 'user_id');
    }
    public function permissions() {
        return $this->belongsToMany(Permission::class, 'permission_role', 'permission_id', 'role_id');
    }
    
}
