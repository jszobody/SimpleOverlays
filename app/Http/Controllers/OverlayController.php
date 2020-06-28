<?php

namespace App\Http\Controllers;

use Cache;
use App\Overlay;
use Illuminate\Http\Request;

class OverlayController
{
    public function createPreview(Request $request)
    {
        Cache::put(
            $hash = uniqid(),
            new Overlay([
                'content' => $request->input('content'),
                'css' => $request->input('css')
            ]),
            600
        );

        return ['hash' => $hash];
    }

    public function preview($hash)
    {
        return view('overlays.preview', Cache::get($hash));
    }
}
