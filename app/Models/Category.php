<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    public function stacks(): HasMany
    {
        return $this->hasMany(Stack::class);
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return team()->categories()->where($field ?? 'id', $value)->firstOrFail();
    }
}
