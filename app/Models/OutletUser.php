<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class OutletUser extends Pivot
{
    //
    protected $table = 'outlet_user';

    public function roles(){
        return $this->belongsTo(Role::class);
    }
}
