<?php 

namespace App\Providers;

use Collective\Annotations\AnnotationsServiceProvider as ServiceProvider;
use Collective\Annotations\Routing\Annotations\Scanner as RouteScanner;


class AnnotationsServiceProvider extends ServiceProvider {

    /**
     * The classes to scan for event annotations.
     *
     * @var array
     */
    protected $scanEvents = [

        // App\Handlers\Events\MailHandler::class,
    ];

    /**
     * The classes to scan for route annotations.
     *
     * @var array
     */
    protected $scanRoutes = [

        // App\Http\Controllers\HomeController::class,
    ];

    /**
     * The classes to scan for model annotations.
     *
     * @var array
     */
    protected $scanModels = [

        // 'App\User',
    ];

    /**
     * Determines if we will auto-scan in the local environment.
     *
     * @var bool
     */
    protected $scanWhenLocal = true;

    /**
     * Determines whether or not to automatically scan the controllers
     * directory (App\Http\Controllers) for routes
     *
     * @var bool
     */
    // protected $scanControllers = false;
    protected $scanControllers = true;

    /**
     * Determines whether or not to automatically scan all namespaced
     * classes for event, route, and model annotations.
     *
     * @var bool
     */
    protected $scanEverything = true;

    /**
     * Add annotation classes to the route scanner
     *
     * @param RouteScanner $namespace
     */
    public function addRoutingAnnotations( RouteScanner $scanner )
    {
        $scanner->addAnnotationNamespace( 'App\Http\Annotations' );
    }
}
