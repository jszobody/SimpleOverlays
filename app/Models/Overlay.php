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
        return $this->generate();
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
        return isset($this->cache_name) && file_exists($this->cache_name);
    }

    public function getThumbprintAttribute()
    {
        return md5(
            $this->content . $this->layout . $this->size . $this->css
        );
    }

    public function cache()
    {
        if ($this->cached) {
            return;
        }

        CacheOverlay::dispatch($this);

        return $this;
    }

    public function generate()
    {
        $saveTo = storage_path("overlays/" . $this->uuid . "_" . $this->thumbprint . ".png");

        if(file_exists($saveTo)) {
            if($this->cache_name != $saveTo) {
                $this->update(['cache_name' => $saveTo]);
            }

            return $saveTo;
        }

        if(!is_dir(dirname($saveTo))) {
            mkdir(dirname($saveTo), 0777, true);
        }

        Browsershot::url(route('overlay-preview', ['uuid' => $this->uuid]))
            ->setScreenshotType('png')
            ->windowSize(1920, 1080)
            ->save($saveTo);

        $this->update([
            'cache_name' => $saveTo
        ]);

        return $saveTo;
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
