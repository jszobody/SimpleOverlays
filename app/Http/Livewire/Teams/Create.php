<?php

namespace App\Http\Livewire\Teams;

use App\Models\Category;
use App\Models\Team;
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

        $team->categories()->saveMany([
            new Category(['name' => 'Event','description' => 'Church service or other date specific event', 'icon' => 'calendar-days']),
            new Category(['name' => 'Template','description' => 'Divine setting or similar templates ', 'icon' => 'clone']),
            new Category(['name' => 'Snippet','description' => 'Hymns, creeds, prayers, and other re-usable snippets', 'icon' => 'puzzle-piece'])
        ]);

        user()->selectTeam($team);

        return $this->redirectRoute('list-stacks', $team->categories()->first()->id);
    }
}
