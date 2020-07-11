<?php

namespace App\Http\Livewire\Teams;

use App\Team;
use Livewire\Component;

class Configure extends Component
{
    public $team;

    public $name;

    public $editDetails = false;

    public function mount(Team $team)
    {
        $this->team = $team;
        $this->name = $this->team->name;
    }

    public function saveDetails()
    {
        $this->validate([
            'name' => 'required',
        ]);

        $this->team->update([
            'name' => $this->name
        ]);

        $this->editDetails = false;
    }

    public function render()
    {
        return view('livewire.teams.configure');
    }
}
