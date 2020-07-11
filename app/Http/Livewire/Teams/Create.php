<?php

namespace App\Http\Livewire\Teams;

use App\Team;
use Livewire\Component;

class Create extends Component
{
    public $name;

    public function render()
    {
        return view('livewire.teams.create');
    }

    public function submit()
    {
        $this->validate([
            'name' => 'required',
        ]);

        $team = Team::newFor(user(), $this->name);

        user()->selectTeam($team);

        return $this->redirectRoute('list-stacks');
    }
}
