<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class LanguageController extends Controller
{
    public function switch(string $code): RedirectResponse
    {
        app(\App\Services\LanguageService::class)->setLocale($code);

        return back();
    }
}
