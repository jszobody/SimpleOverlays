<?php

namespace App\Http\Controllers;

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
}
