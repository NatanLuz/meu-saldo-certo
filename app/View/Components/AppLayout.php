<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    /**
    * Retorna a view que representa o componente.
     */
    public function render(): View
    {
        return view('layouts.app');
    }
}
