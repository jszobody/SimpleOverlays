<?php

namespace App\Models;

use App\Events\SessionUpdated;
use App\Models\Overlay;
use App\Models\Stack;
use App\Support\RandomName;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'visible' => 'boolean',
    ];

    protected $dispatchesEvents = [
        'updated' => SessionUpdated::class,
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->slug = RandomName::generate();
            $model->overlay_id = $model->stack->overlays()->first()->id;
        });
    }

    public function stack()
    {
        return $this->belongsTo(Stack::class);
    }

    public function overlay()
    {
        return $this->belongsTo(Overlay::class);
    }

    public function toggle()
    {
        return $this->update(['visible' => ! $this->getAttribute('visible')]);
    }
}
