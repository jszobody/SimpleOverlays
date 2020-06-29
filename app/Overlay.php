<?php

namespace App;

use App\Parsing\Parser;
use Illuminate\Database\Eloquent\Model;
use ParsedownExtra;

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
        return nl2br(
            (new Parser($this->stack->transformations))->text($this->content)
        );
    }

    public function getCssClassesAttribute()
    {
        return $this->css
            ? implode(" ", $this->css)
            : "";
    }
}
