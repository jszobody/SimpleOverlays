<?php

namespace App\Http\Controllers;

use App\Models\Overlay;
use App\Models\Stack;
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

        $prefix = $stack->occurs_at
            ? $stack->occurs_at->format('Fj') . '_'
            : '';

        return Zip::create(
            $stack->zip_name,
            $stack->overlays
                ->mapWithKeys(fn (Overlay $overlay, $index) => [$overlay->cache_name => $prefix . 'overlay_'.($index + 1).'.png'])
                ->toArray()
        );
    }
}
