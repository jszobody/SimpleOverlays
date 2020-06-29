<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Overlay extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'css' => 'json'
    ];

    public function stack()
    {
        return $this->belongsTo(Stack::class);
    }

    public function getFinalAttribute()
    {
        return nl2br($this->content);
    }

    public function getCssClassesAttribute()
    {
        return $this->css
            ? implode(" ", $this->css)
            : "";
    }
}
