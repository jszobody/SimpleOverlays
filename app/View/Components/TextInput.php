<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TextInput extends Component
{
    public $id;

    public $error;

    public function __construct($id, $error = false)
    {
        $this->id = $id;
        $this->error = $error;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return <<<'blade'
            <input id="{$this->id}"
            {{ $attributes->merge([
                'class' => 'form-input w-full block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5 '
                . ($error ? "border-red-500" : "")
            ]) }}
            />
        blade;
    }
}
