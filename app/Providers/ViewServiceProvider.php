<?php

namespace App\Providers;

use App\View\Composers\ShopComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Áp dụng cho toàn bộ view thuộc layout "layouts.app" và các partials liên quan
        View::composer(
            ['layouts.app', 'partials.header', 'partials.footer', 'partials.widgets', 'home.index', 'products.*', 'cart.*', 'checkout.*', 'auth.customer.*', 'pages.*'],
            ShopComposer::class
        );
    }
}
