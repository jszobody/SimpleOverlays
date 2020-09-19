<?php

namespace App\Http\Livewire\Session;

use App\Http\Livewire\Stacks\Present;
use App\Overlay;
use App\Session;
use Livewire\Component;

class View extends Present
{
    public function mount($slug, $format = 'html')
    {
        $this->format = $format;
        $this->session = Session::whereSlug($slug)->first();
        $this->stack = $this->session->stack;
        $this->sessionSlug = $this->session->slug;
        $this->setCurrent($this->session->overlay);
    }

    public function render()
    {
        $this->temp = $this->flash;

        if (request('preview')) {
            $this->current = $this->next;
        }

        return view('livewire.session.view');
    }
}
