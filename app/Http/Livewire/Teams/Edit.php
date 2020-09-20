<?php

namespace App\Http\Livewire\Teams;

use App\Team;
use Livewire\Component;

class Edit extends Component
{
    public $team;

    public function mount(Team $team)
    {
        $this->team = $team;
    }

    public function render()
    {
        return view('livewire.teams.edit');
    }

    public function invite()
    {

    }
}
