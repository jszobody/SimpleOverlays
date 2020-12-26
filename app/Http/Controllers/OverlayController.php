<?php

namespace App\Http\Controllers;

use App\Models\Overlay;
use App\Models\Stack;
use Illuminate\Http\File;
use Response;
use Storage;
use Symfony\Component\Finder\SplFileInfo;

class OverlayController
{
    public function preview($uuid)
    {
        return view('stacks.overlay', [
            'overlay' => Overlay::whereUuid($uuid)->firstOrFail(),
        ]);
    }

    public function png($uuid)
    {
        return redirect(
            Overlay::whereUuid($uuid)->firstOrFail()->png
        );
    }

    public function download($uuid, $index)
    {
        return response(
            file_get_contents(Overlay::whereUuid($uuid)->firstOrFail()->png_url),
            200,
            [
                'Content-type'        => 'image/png',
                'Content-Disposition' => 'attachment; filename="overlay_' . $index . '.png"',
            ]
        );
    }
}
