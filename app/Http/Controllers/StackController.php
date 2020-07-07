<?php

namespace App\Http\Controllers;

use App\Overlay;
use Cache;
use Zip;
use App\Stack;

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
        return Zip::create(
            $stack->title . ".zip",
            $stack->overlays->mapWithKeys(function(Overlay $overlay, $index) {
                return [$overlay->file_path => "overlay_" . ($index + 1) . ".png"];
            })->toArray()
        );
    }
}
