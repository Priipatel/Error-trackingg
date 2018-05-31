<?php

namespace Errorlog\errortrack;

use Illuminate\Support\ServiceProvider;
use laravel\errortrack\Middleware\ErrortrackSession;
use Illuminate\Support\Facades\Schema;

class ErrorTrackServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */

    protected $defer = false;


    protected $middleware = [
        'ErrortrackSession' => __DIR__.'\Middlewares\ErrortrackSession::class'
    ];


    public function boot(\Illuminate\Routing\Router $router, \Illuminate\Contracts\Http\Kernel $kernel)
    {
     $this->loadRoutesFrom(__DIR__.'/routes/web.php');

    $this->loadViewsFrom(__DIR__.'/resources/views', 'Errorlog');

    $this->publishes([
        __DIR__.'/resources/views' => resource_path('views/vendor/errorlog'),
    ]);

     $this->app->bind(
            ExceptionHandler::class,
            CustomHandler::class
        ); 


    $this->publishes([
         __DIR__.'/config/config.php' => config_path('Errorlog/errortrack/config.php'),
    ]);

    $this->publishes([
         __DIR__.'/Exceptions/CustomHandler.php' => app_path('Errorlog/errortrack'),
    ]);

        // $this->loadRoutesFrom(__DIR__ . '/routes.php');
        
        // if ($this->app->config->get('config') === null) {
        //     $this->app->config->set('config', require __DIR__ . '/config/config.php');
        // }

         $this->loadMigrationsFrom(__DIR__.'/migrations');

    //  $this->publishes([
    //     __DIR__ . '/migrations' => $this->app->databasePath() . '/migrations'
    // ], 'migrations');

        // $router->middleware('ErrortrackSession',ErrortrackSession::class);
       

    }

    

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
     include __DIR__.'/routes/web.php';
       
        // $this->app['router']->aliasMiddleware('ErrortrackSession' , ErrortrackSession::class);
    }
}
