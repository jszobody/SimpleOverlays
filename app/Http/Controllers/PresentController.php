<?php

namespace App\Http\Controllers;

use App\Overlay;
use App\Stack;

class PresentController
{
    public function preview($uuid)
    {
        $overlay = Overlay::whereUuid($uuid)->firstOrFail();

        return view('stacks.preview', [
            'overlay' => $overlay,
            'stack' => $overlay->stack,
        ]);
    }
}
