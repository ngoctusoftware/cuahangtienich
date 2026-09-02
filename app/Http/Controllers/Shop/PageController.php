<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\View\View;

class PageController extends Controller
{
    public function show(string $key): View
    {
        $content = Content::with('translations')->where('key', $key)->where('is_active', true)->firstOrFail();

        return view('pages.show', compact('content'));
    }
}
