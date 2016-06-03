<?php
namespace AFSardo\PlainQueue;

use AFSardo\PlainQueue\Connectors\BeanstalkdPlainConnector;

use Illuminate\Support\ServiceProvider;

class BeanstalkdPlainServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Add the connector to the queue drivers.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['queue']->addConnector('beanstalkd-plain', function () {
            return new BeanstalkdPlainConnector();
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        
    }

}