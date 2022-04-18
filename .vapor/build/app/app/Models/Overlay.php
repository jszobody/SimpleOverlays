<?php

namespace App\Models;

use App\Collections\OverlayCollection;
use App\Jobs\CacheOverlay;
use App\Parsing\Parser;
use App\Models\Stack;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\File;
use Illuminate\Support\Str;
use Spatie\Browsershot\Browsershot;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Storage;
use STS\SnapThis\Client;
use STS\SnapThis\Facades\SnapThis;
use STS\SnapThis\Snapshot;

class Overlay extends Model implements Sortable
{
    use SortableTrait;

    protected $guarded = ['id'];

    protected $casts = [
        'css' => 'json',
        'cache_expires_at' => 'datetime'
    ];

    public $sortable = [
        'order_column_name' => 'sort',
        'sort_when_creating' => true,
    ];

    protected static function booted()
    {
        static::creating(function ($overlay) {
            $overlay->uuid = (string) Str::uuid();
        });

        static::updating(function (Overlay $overlay) {
            if($overlay->isDirty(['content', 'layout', 'size'])) {
                $overlay->clearCache();
            }
        });
    }

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
            ? implode(' ', $this->css)
            : '';
    }

    public function getFilePathAttribute()
    {
        return Storage::disk('s3')->path($this->generate());
    }

    public function getPngUrlAttribute()
    {
        if(!$this->cached) {
            $this->generate();
        }

        return $this->cache_url;
    }

    public function getPngAttribute()
    {
        return redirect($this->cache_url);
    }

    public function getUuidAttribute()
    {
        if (empty($this->attributes['uuid'])) {
            $this->update(['uuid' => (string) Str::uuid()]);
        }

        return $this->attributes['uuid'];
    }

    public function getCachedAttribute()
    {
        return isset($this->cache_name) && isset($this->cache_expires_at) && $this->cache_expires_at->isFuture();
    }

    public function cache()
    {
        if ($this->cached) {
            return;
        }

        CacheOverlay::dispatch($this);

        return $this;
    }

    public function generate($name = "snapshot.png"): Snapshot
    {
        /** @var Client $client */
        $client = app()->environment('local')
            ? SnapThis::view('stacks.overlay', ['overlay' => $this])
            : SnapThis::url(route('overlay-preview', ['uuid' => $this->uuid]));

        /** @var Snapshot $snapshot */
        $client = $client
            ->name($name)
            ->expiration(now()->addDays(30));

        $snapshot = retry(3, function() use($client) {
            return $client->snapshot();
        }, 3);

        //info(json_encode($snapshot->toArray()));

        $this->update([
            'cache_name' => $snapshot->name,
            'cache_url' => $snapshot->url,
            'cache_expires_at' => $snapshot->expires
        ]);

        return $snapshot;
    }

    public function moveBefore(self $otherModel)
    {
        $this->sort = $otherModel->sort;
        $this->stack->overlays()->where('sort', '>=', $otherModel->sort)->increment('sort');
        $this->save();

        return $this;
    }

    public function moveAfter(self $otherModel)
    {
        $this->sort = $otherModel->sort + 1;
        $this->stack->overlays()->where('sort', '>=', $otherModel->sort + 1)->increment('sort');
        $this->save();

        return $this;
    }

    public function moveToPosition($position)
    {
        if ($otherModel = $this->stack->overlays->get($position)) {
            return $this->moveBefore($otherModel);
        }

        return $this->moveToEnd();
    }

    public function clearCache()
    {
        $this->cache_name = null;
        $this->cache_url = null;
        $this->cache_expires_at = null;
    }

    public function newCollection(array $models = [])
    {
        return new OverlayCollection($models);
    }
}
