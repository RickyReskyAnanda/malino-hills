<?php

namespace App\View\Components\Layouts;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class PageHeader extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public string $subtitle,  public string $title, public string $url="assets/image/page-header/background2.jpg")
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layouts.page-header');
    }
}
