<?php

namespace App;

use App\Parsing\Parser;
use Illuminate\Database\Eloquent\Model;
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
}
