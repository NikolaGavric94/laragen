<?php

namespace Nikolag\Generator\Test;

use Illuminate\Support\Facades\Storage;
use Nikolag\Generator\Converter\ModelConverter;
use Nikolag\Generator\Template\TemplateLoader;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{

    /**
     * @var TemplateLoader
     */
    protected $loader;

    /**
     * Setup the test environment.
     */
    public function setUp()
    {
        parent::setUp();
        $this->loader = $this->app->make(TemplateLoader::class);
    }

    /**
     * add the package provider
     *
     * @param $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            'Nikolag\Generator\Provider\GeneratorServiceProvider'
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }
}