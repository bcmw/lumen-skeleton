<?php

require_once __DIR__.'/../vendor/autoload.php';

try {
    Dotenv::load(__DIR__.'/../');
} catch (Exception $e) {
    exit($e->getMessage());
}

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

use Laravel\Lumen\Application as BaseApplication;

class Application extends BaseApplication
{
    // Because this pull (https://github.com/laravel/lumen-framework/pull/21) will not be accepted by the strict moderators of Lumen, such a shame...
    public function getPathInfo()
    {
        $query = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '';
        $folder = dirname($_SERVER['SCRIPT_NAME']);
        $uri = $_SERVER['REQUEST_URI'];
        if ($folder != $uri && strpos($uri, $folder) === 0) {
            $uri = substr($uri, strlen($folder));
        }
        return '/'.ltrim(str_replace('?'.$query, '', $uri), '/');
    }
}

$app = new Application(
    realpath(__DIR__.'/../')
);

// $app = new Laravel\Lumen\Application(
//     realpath(__DIR__.'/../')
// );

// $app->withFacades();

// $app->withEloquent();

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/

// $app->middleware([
//     // Illuminate\Cookie\Middleware\EncryptCookies::class,
//     // Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
//     // Illuminate\Session\Middleware\StartSession::class,
//     // Illuminate\View\Middleware\ShareErrorsFromSession::class,
//     // Laravel\Lumen\Http\Middleware\VerifyCsrfToken::class,
// ]);

// $app->routeMiddleware([

// ]);

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/

// $app->register(App\Providers\AppServiceProvider::class);
// $app->register(App\Providers\EventServiceProvider::class);
$app->register(App\Providers\RouteServiceProvider::class);
$app->configure('twigbridge');
$app->register(TwigBridge\ServiceProvider::class);

return $app;
