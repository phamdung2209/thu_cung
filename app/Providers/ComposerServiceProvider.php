<?php

namespace App\Providers;

use App\Http\ViewComposers\CartComposer;
use App\Http\ViewComposers\CategoryComposer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // View::composer(
        //     ['frontend.inc.footer', 'frontend.'.get_setting('homepage_select').'.partials.cart', 'frontend.'.get_setting('homepage_select').'.partials.product_box_1'],
        //     CartComposer::class
        // );
    }
}
