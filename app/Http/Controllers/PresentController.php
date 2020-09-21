<?php

namespace App\Http\Controllers;

use App\Overlay;
use App\Stack;

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
