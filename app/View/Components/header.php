<?php

namespace App\View\Components;

use Illuminate\View\Component;

class header extends Component
{

    public $title;
    public $createRoute;
    public $withSearch;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $createRoute = null, $withSearch = false)
    {
        $this->title = $title;
        $this->createRoute = $createRoute;
        $this->withSearch = $withSearch;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.header');
    }
}
