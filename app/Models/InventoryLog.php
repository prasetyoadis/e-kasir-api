<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class InventoryLog extends Model
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
    public function inventoryItem()
    {
        return $this->belongsTo(InventoryItem::class);
    }

    public function outlet() {
        return $this->belongsTo(Outlet::class);
    }

    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }
}
