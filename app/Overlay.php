<?php

namespace App;

use App\Collections\OverlayCollection;
use App\Jobs\CacheOverlay;
use Illuminate\Http\File;
use Illuminate\Support\Str;
use Storage;
use App\Parsing\Parser;
use Illuminate\Database\Eloquent\Model;
use Spatie\Browsershot\Browsershot;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Overlay extends Model implements Sortable
{
    use SortableTrait;

    protected $guarded = ['id'];

    protected $casts = [
        'css' => 'json'
    ];

    public $sortable = [
        'order_column_name' => 'sort',
        'sort_when_creating' => true,
    ];

    protected static function booted()
    {
        static::updating(function ($overlay) {
            $overlay->updateCacheName();
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
            ? implode(" ", $this->css)
            : "";
    }

    public function getFilePathAttribute()
    {
        return Storage::disk('s3')->path($this->generate());
    }

    public function getPngAttribute()
    {
        return Storage::disk('s3')->url($this->generate());
//        return Storage::disk('s3')->download(
//            $this->generate(),
//            $this->uuid . ".png",
//            ['X-Vapor-Base64-Encode' => 'True']
//        );
    }

    public function getUuidAttribute()
    {
        if(empty($this->attributes['uuid'])) {
            $this->update(['uuid' => (string) Str::uuid()]);
        }

        return $this->attributes['uuid'];
    }

    public function getCachedAttribute()
    {
        return Storage::disk('s3')->has($this->cache_name);
    }

    public function getCachePathAttribute()
    {
        return 's3://' . config('filesystems.disks.s3.bucket') . '/' . $this->cache_name;
    }

    public function cache()
    {
        if($this->cached) {
            return;
        }

        CacheOverlay::dispatch($this);

        return $this;
    }

    public function generate()
    {
        if(!$this->cached) {
            Browsershot::url(route('overlay-preview', ['uuid' => $this->uuid]))
                ->setNodeBinary('/opt/bin/node')
                ->setNodeModulePath('/opt/nodejs/node_modules')
                ->setBinPath(base_path('resources/browser.js'))
                ->windowSize(1920, 1080)
                ->hideBackground()
                ->save(sys_get_temp_dir() . "/tmp.png");

            Storage::disk('s3')->putFileAs('', new File(sys_get_temp_dir() . "/tmp.png"), $this->cache_name, 'public');
        }

        return $this->cache_name;
    }

    public function moveBefore(Overlay $otherModel)
    {
        $this->sort = $otherModel->sort;
        $this->stack->overlays()->where('sort', '>=', $otherModel->sort)->increment('sort');
        $this->save();
        return $this;
    }

    public function moveAfter(Overlay $otherModel)
    {
        $this->sort = $otherModel->sort +1;
        $this->stack->overlays()->where('sort', '>=', $otherModel->sort + 1)->increment('sort');
        $this->save();
        return $this;
    }

    public function moveToPosition($position)
    {
        if($otherModel = $this->stack->overlays->get($position)) {
            return $this->moveBefore($otherModel);
        }

        return $this->moveToEnd();
    }

    public function updateCacheName()
    {
        $this->cache_name = $this->id . "_" . md5(serialize($this->attributes)) . ".png";

        return $this;
    }

    public function newCollection(array $models = [])
    {
        return new OverlayCollection($models);
    }
}
