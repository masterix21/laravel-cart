<?php

namespace Masterix21\LaravelCart\View;

use Illuminate\View\Component;

class IconDropdown extends Component
{
    public function __construct(
        public string $menuClass = ''
    ) {
    }

    public function render()
    {
        return view('cart::icon-dropdown');
    }
}
