<?php

namespace Stevebauman\EloquentTable;

use Illuminate\Support\ServiceProvider;

class EloquentTableServiceProvider extends ServiceProvider {
    
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
        $this->package('stevebauman/eloquenttable');
        
        include __DIR__ .'/../../helpers.php';
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
            return array('eloquenttable');
    }
    
}