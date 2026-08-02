<?php

namespace App\Http\Controllers;

class SettingsController extends Controller
{
    /**
     * Show the user's settings page.
     */
    public function edit()
    {
        return view('pages.settings.edit');
    }
}
