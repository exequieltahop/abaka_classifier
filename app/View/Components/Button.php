<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    /**
     * Create a new component instance.
     */
    public string $buttonClass, $id, $type, $icon;

    public function __construct($buttonClass = "", $id = "", $type = "button", $icon = "")
    {
        $this->buttonClass = $buttonClass;
        $this->id = $id;
        $this->type = $type;
        $this->icon = $icon;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.button');
    }
}
