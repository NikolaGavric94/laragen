<?php

namespace Nikolag\Generator\Provider;

use Illuminate\Support\ServiceProvider;
use Nikolag\Generator\Converter\ModelConverter;

class GeneratorServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Nikolag\Generator\Helper\Contract\Spacer', 'Nikolag\Generator\Helper\Spacer');
        $this->app->bind('Nikolag\Generator\Helper\Contract\Replacer', 'Nikolag\Generator\Helper\Replacer');

        $this->app->bind('Nikolag\Generator\Converter\Contract\Model', function($app) {
            return new ModelConverter(
                $app->make('Nikolag\Generator\Template\TemplateLoader'),
                $app->make('Nikolag\Generator\Helper\Contract\Spacer'),
                $app->make('Nikolag\Generator\Helper\Contract\Replacer')
            );
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            "Nikolag\Generator\Converter\ModelConverter",
            "Nikolag\Generator\Helper\Spacer",
            "Nikolag\Generator\Helper\Replacer",
        ];
    }
}