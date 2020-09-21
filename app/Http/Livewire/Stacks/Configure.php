<?php

namespace App\Http\Livewire\Stacks;

use App\Stack;
use Carbon\Carbon;
use Livewire\Component;

class Configure extends Component
{
    /** @var Stack */
    public $stack;

    public $occurs;

    protected $rules = [
        'stack.title' => 'required',
    ];

    /** @var bool */
    public $editDetails = false;

    public $transformations = [];

    public function mount(Stack $stack)
    {
        $this->stack = $stack;
        $this->occurs = $this->stack->occurs_at ? $this->stack->occurs_at->format('F j, Y') : null;
        $this->theme = $this->stack->theme_id;
        $this->transformations = $this->stack->transformations->pluck('id')->map(function ($id) {
            return (string) $id;
        })->toArray();
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function saveDetails()
    {
        $this->validate();

        $this->stack->update([
            'occurs_at' => $this->occurs ? Carbon::parse($this->occurs) : null,
        ]);

        $this->stack->transformations()->sync($this->transformations);
        $this->stack->unsetRelations();

        $this->editDetails = false;
    }

    public function cancel()
    {
        $this->stack = $this->stack->fresh();
        $this->editDetails = false;
    }

    public function archive()
    {
        $this->stack->archive();

        return $this->redirectRoute('list-stacks');
    }

    public function render()
    {
        return view('livewire.stacks.configure');
    }
}
