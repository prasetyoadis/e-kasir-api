<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Role extends Model
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
