<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stack extends Model
{
    protected $guarded = ['id'];

    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }

    public function overlays()
    {
        return $this->hasMany(Overlay::class);
    }
}
