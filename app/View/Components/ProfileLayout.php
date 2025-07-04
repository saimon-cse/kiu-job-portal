<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class ProfileLayout extends Component
{
    public function render(): View
    {
        // This tells Laravel to use the 'profile.layout' Blade file
        return view('profile.layout');
    }
}
