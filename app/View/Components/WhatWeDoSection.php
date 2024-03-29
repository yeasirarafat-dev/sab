<?php

namespace App\View\Components;

use Illuminate\View\Component;

class WhatWeDoSection extends Component
{
    public $whatweare;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($other)
    {
        //
        $this->whatweare = $other->whatweare;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.what-we-do-section');
    }
}
