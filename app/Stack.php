<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stack extends Model
{
    protected $guarded = ['id'];

    protected $casts = ['occurs_at' => 'datetime'];

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
        return $this->belongsToMany(Transformation::class)->orderBy('name');
    }

    public function sessions()
    {
        return $this->hasMany(Session::class);
    }

    public function scopeActive($query)
    {
        $query->whereNull('archived_at');
    }

    public function getZipNameAttribute()
    {
        return $this->occurs_at
            ? $this->title.' - '.$this->occurs_at->format('F j Y').'.zip'
            : $this->title.'.zip';
    }

    public function insertFrom(self $stack, Overlay $selected)
    {
        // First bump up the sort order of all our own overlays after the selected overlay, to make room
        $this->overlays()->where('sort', '>', $selected->sort)->increment('sort', $stack->overlays->count());
        $sort = $selected->sort + 1;

        // Now replicate each overlay, set the new sort, and save on our own stack
        foreach ($stack->overlays as $overlay) {
            $this->overlays()->save(
                tap($overlay->replicate(['uuid']), function (Overlay $new) use ($sort) {
                    $new->sortable['sort_when_creating'] = false;
                    $new->sort = $sort;
                })
            );
            $sort++;
        }

        $this->unsetRelation('overlays');
    }

    public function archive()
    {
        $this->update(['archived_at' => now()]);
    }
}
