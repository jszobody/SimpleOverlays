<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stack extends Model
{
    protected $guarded = ['id'];

    public function overlays()
    {
        return $this->hasMany(Overlay::class);
    }
}
