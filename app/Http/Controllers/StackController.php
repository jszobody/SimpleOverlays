<?php

namespace App\Http\Controllers;

use App\Overlay;
use App\Stack;
use Cache;
use STS\ZipStream\Models\S3File;
use Zip;

class StackController
{
    public function preview(Stack $stack, Overlay $overlay)
    {
        return view('stacks.overlay', [
            'overlay' => $overlay,
            'stack' => $stack,
        ]);
    }

    public function view(Stack $stack, Overlay $overlay)
    {
        return $overlay->png;
    }

    public function zip(Stack $stack)
    {
        if (! $stack->overlays->every->cached) {
            return redirect()->route('build-stack', ['stack' => $stack]);
        }

        return Zip::create(
            $stack->zip_name,
            $stack->overlays->mapWithKeys(function (Overlay $overlay, $index) {
                return [$overlay->cache_path => 'overlay_'.($index + 1).'.png'];
            })->toArray()
        );
    }
}
