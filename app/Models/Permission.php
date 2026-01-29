<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Permission extends Model
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
    public function roles() {
        return $this->belongsToMany(
            Role::class, 
            'permission_role', 
            'role_id', 
            'permission_id'
        )->withTimestamps();
    }
}
