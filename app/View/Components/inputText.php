<?php

namespace App\View\Components;

use Illuminate\View\Component;

class inputText extends Component
{
    public $name;
    public $label;
    public $value;
    public $placeholder;
    public $icon;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $name,
        $label,
        $value = null,
        $placeholder,
        $icon,
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;
        $this->placeholder = $placeholder;
        $this->icon = $icon;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.input-text');
    }
}
