<?php

namespace App\Collections;

use App\Overlay;
use Illuminate\Database\Eloquent\Collection;

class OverlayCollection extends Collection
{
    public function after( Overlay $overlay )
    {
        return $this->get($this->getIndex($overlay) + 1);
    }

    public function before( Overlay $overlay )
    {
        return $this->get($this->getIndex($overlay) - 1);
    }

    public function getIndex( Overlay $find )
    {
        foreach ($this->items as $index => $overlay) {
            if ($overlay->id == $find->id) {
                return $index;
            }
        };
    }
}
