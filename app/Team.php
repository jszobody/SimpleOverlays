<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Team extends Model
{
    use HasSlug;

    protected $guarded = ["id"];

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

    public function stacks()
    {
        return $this->hasMany(Stack::class)
            ->active()
            ->withCount('overlays')
            ->orderBy('id', 'DESC')
            ->orderBy('occurs_at', 'DESC');
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

    public static function newFor(User $user)
    {
        $team = static::create(['name' => $user->name . "'s team"]);
        $user->join($team);

        return $team;
    }
}
