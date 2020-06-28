<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Overlay extends Model
{
    protected $guarded = ['id'];

    public function stack()
    {
        return $this->belongsTo(Stack::class);
    }
}
