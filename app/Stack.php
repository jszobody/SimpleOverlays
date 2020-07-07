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
        return $this->hasMany(Overlay::class)->ordered();
    }

    public function transformations()
    {
        return $this->belongsToMany(Transformation::class);
    }

    public function sessions()
    {
        return $this->hasMany(Session::class);
    }

    public function insertFrom(Stack $stack, Overlay $selected)
    {
        // First bump up the sort order of all our own overlays after the selected overlay, to make room
        $this->overlays()->where('sort', '>', $selected->sort)->increment('sort', $stack->overlays->count());
        $sort = $selected->sort + 1;

        // Now replicate each overlay, set the new sort, and save on our own stack
        foreach($stack->overlays AS $overlay) {
            $new = tap($overlay->replicate(), function(Overlay $new) use($sort) {
                $new->sortable['sort_when_creating'] = false;
                $new->sort = $sort;
            });
            dd($selected, $new);
            $this->overlays()->save(
                tap($overlay->replicate(), function(Overlay $new) use($sort) {
                    $new->sortable['sort_when_creating'] = false;
                    $new->sort = $sort;
                })
            );
            $sort++;
        }
    }
}
