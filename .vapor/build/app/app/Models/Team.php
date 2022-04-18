<?php

namespace App\Models;

use App\Models\Stack;
use App\Models\Theme;
use App\Models\Transformation;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Team extends Model
{
    use HasSlug;

    protected $guarded = ['id'];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function stacks()
    {
        return $this->hasMany(Stack::class)
            ->active()
            ->withCount('overlays')
            ->orderBy('id', 'DESC')
            ->orderBy('occurs_at', 'DESC');
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function templates()
    {
        return $this->hasMany(Stack::class)->whereHas('category', function($query) {
            $query->where('name', 'Template');
        });
    }

    public function transformations()
    {
        return $this->hasMany(Transformation::class);
    }

    public function getThemesAttribute()
    {
        return Theme::orderBy('name')->get();
    }

    public function getTransformationsAttribute()
    {
        return Transformation::orderBy('name')->get();
    }

    public static function newFor(User $user, $name = null)
    {
        $team = static::create([
            'name' => $name ?? $user->name."'s team",
            'owner_id' => $user->id,
        ]);

        $user->join($team);

        return $team;
    }
}
