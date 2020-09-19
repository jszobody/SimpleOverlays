<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Regex extends Model
{
    protected $guarded = ['id'];

    public function transformation()
    {
        return $this->belongsTo(Transformation::class);
    }
}
