<?php

namespace App\Http\Controllers;

use App\Overlay;
use Cache;
use App\Stack;

class StackController
{
    public function list()
    {
        return view('stacks.list', [
            'stacks' => Stack::orderBy('id')
                ->withCount('overlays')->get()
        ]);
    }

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
}
