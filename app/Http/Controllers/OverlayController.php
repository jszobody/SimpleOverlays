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
        return response()->file(Overlay::whereUuid($uuid)->firstOrFail()->generate());
    }

    public function download($uuid, $index)
    {
        $overlay = Overlay::whereUuid($uuid)->firstOrFail();

        $prefix = $overlay->stack->occurs_at
            ? $overlay->stack->occurs_at->format('Fj') . '_'
            : '';

        return response(
            file_get_contents($overlay->generate()),
            200,
            [
                'Content-type'        => 'image/png',
                'Content-Disposition' => 'attachment; filename="' . $prefix . 'overlay_' . $index . '.png"',
            ]
        );
    }
}
