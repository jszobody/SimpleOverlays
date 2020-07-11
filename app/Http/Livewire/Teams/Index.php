<?php

namespace App\Http\Livewire\Teams;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.teams.index', [
            'teams' => user()->memberTeams
        ]);
    }
}
