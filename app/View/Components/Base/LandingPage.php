<?php

namespace App\View\Components\Base;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class LandingPage extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public string $isTransparentNavbar)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.base.landing-page');
    }
}
