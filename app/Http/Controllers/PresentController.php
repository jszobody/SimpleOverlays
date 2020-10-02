<?php

namespace App\Http\Controllers;

use App\Models\Overlay;
use App\Models\Stack;

class PresentController
{
    public function overlay($uuid)
    {
        return Overlay::whereUuid($uuid)->firstOrFail()->png;
    }

    public function png($uuid)
    {
        return Overlay::whereUuid($uuid)->firstOrFail()->png;
    }
}
