<?php 

namespace Pitsolu\RbacNot;

/**
 * This file is part of Entrust,
 * a role & permission management solution for Laravel.
 *
 * @license MIT
 * @package Pitsolu\RbacNot
 */

use Illuminate\Support\ServiceProvider;
use Strukt\Fs;

class RbacNotServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {

        $path = app()->basePath();

        Fs::mkdir(sprintf("%s/app/Http/Annotations", $path));

        // Publish config files
        $this->publishes([

            __DIR__.'/../app/' => sprintf('%s/app/', $path),
            __DIR__.'/../database/' => sprintf('%s/database/', $path),
        ]);

        $this->commands('command.rbacnot.setup');
        $this->commands('command.entrust.clean');
    }

    public function registerRbacNotSetupCommand(){

        $this->app->singleton('command.rbacnot.setup', function ($app){

            return new \Pitsolu\RbacNot\Commands\RbacNotSetupCommand();
        });
    }

    public function registerEntrustSanitizeCommand(){

        $this->app->singleton('command.entrust.clean', function ($app){

            return new \Pitsolu\RbacNot\Commands\EntrustSanitizeCommand();
        });
    }

    public function register(){

        $this->registerRbacNotSetupCommand();    
        $this->registerEntrustSanitizeCommand();    
    }

    public function provides(){

        return [
            
            'command.rbacnot.setup',
            'command.entrust.clean'
        ];
    }
}