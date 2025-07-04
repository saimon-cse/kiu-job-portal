<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function __invoke(Request $request): View
    {
        // Simply return the view for the user's settings page.
        // The forms inside will handle their own POST requests.
        return view('user.profile.settings', [
            'user' => $request->user(),
        ]);
    }
}
