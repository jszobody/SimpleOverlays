<?php

namespace App\Http\Controllers;

use App\Overlay;
use App\Stack;
use Response;
use Storage;

class OverlayController
{
    public function preview($uuid)
    {
        return view('stacks.overlay', [
            'overlay' => Overlay::whereUuid($uuid)->firstOrFail()
        ]);
    }

    public function png($uuid)
    {
        return redirect(
            Overlay::whereUuid($uuid)->firstOrFail()->png
        );
    }
}
