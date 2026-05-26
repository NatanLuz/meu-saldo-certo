<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class GuestLayout extends Component
{
    /**
    * Retorna a view que representa o componente.
     */
    public function render(): View
    {
        return view('layouts.guest');
    }
}
