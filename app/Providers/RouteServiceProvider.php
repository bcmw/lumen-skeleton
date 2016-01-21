<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /*
        |--------------------------------------------------------------------------
        | Load The Application Routes
        |--------------------------------------------------------------------------
        |
        | Next we will include the routes file so that they can all be added to
        | the application. This will provide all of the URLs the application
        | can respond to, as well as the controllers that may handle them.
        |
        */

        $this->app->group(['namespace' => 'App\Http\Controllers'], function ($app) {
            /*
            |--------------------------------------------------------------------------
            | Application Routes
            |--------------------------------------------------------------------------
            |
            | Here is where you can register all of the routes for an application.
            | It's a breeze. Simply tell Laravel the URIs it should respond to
            | and give it the controller to call when that URI is requested.
            |
            */

            $app->get('/', function() use ($app) {
                return $app->version();
            });
        });
    }
}
