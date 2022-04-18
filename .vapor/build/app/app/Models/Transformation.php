<?php

namespace App\Models;

use App\Models\Regex;
use App\Models\Stack;
use Illuminate\Database\Eloquent\Model;

class Transformation extends Model
{
    protected $guarded = ['id'];

    public function regexes()
    {
        return $this->hasMany(Regex::class);
    }

    public function stacks()
    {
        return $this->belongsToMany(Stack::class);
    }

    public function transform($line)
    {
        return trim(
            preg_replace(
                $this->regexes->map->find->toArray(),
                $this->regexes->map->replace->toArray(),
                $line
            )
        );
    }
}
