<?php

namespace App\Http\Controllers;

class LanguageController extends Controller
{
    public function switch(string $locale)
    {
        if (in_array($locale, ['es', 'en'])) {
            session(['locale' => $locale]);
        }

        return back();
    }
}
