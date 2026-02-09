<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class TransactionCart extends Model
{
    use HasUlids;

    protected $table = "transaction_cart";

    /**
     * The attributes that are mass protecable.
     *
     * @var list<string>, String
     */
    protected $guarded = ['id'];
    protected $keyType = 'string';

    /**
     * The attributes that are mass public.
     *
     * @var bool
     */
    public $incrementing = false;
    
}
