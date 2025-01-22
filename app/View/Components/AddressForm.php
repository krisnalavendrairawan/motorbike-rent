<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AddressForm extends Component
{
    public $name;
    public $label;
    public $value;
    public $placeholder;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $name = 'address',
        $label = 'Address',
        $value = null,
        $placeholder = 'Enter your address'
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;
        $this->placeholder = $placeholder;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.address-form');
    }
}
