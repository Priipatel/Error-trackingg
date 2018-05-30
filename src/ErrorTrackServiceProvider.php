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
      $this->loadViewsFrom(__DIR__.'/../resources/views', 'test');

    $this->publishes([
        __DIR__.'/views' => base_path('resources/views/Errorlog/errortrack'),
    ]);

        // $this->loadRoutesFrom(__DIR__ . '/routes.php');
        
        // if ($this->app->config->get('config') === null) {
        //     $this->app->config->set('config', require __DIR__ . '/config/config.php');
        // }

        // $this->loadMigrationsFrom(__DIR__.'/migrations');

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
       $this->mergeConfig();
        // $this->app['router']->aliasMiddleware('ErrortrackSession' , ErrortrackSession::class);
    }
}
