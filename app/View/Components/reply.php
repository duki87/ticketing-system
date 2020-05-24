<?php

namespace App\View\Components;

use Illuminate\View\Component;

class reply extends Component
{
    public $ticket;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($ticket, $errors = null)
    {
        $this->ticket = $ticket;
        $this->errors = $errors;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.reply');
    }
}
