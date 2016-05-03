<?php namespace EricLagarda\Temporal;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;


class TemporalServiceProvider extends LaravelServiceProvider {

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
    public function boot() {

        // $this->handleConfigs();
        // $this->handleMigrations();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {

        $this->app['temporal'] = $this->app->share(function($app)
        {
            return new Temporal;
        });

        $this->app->booting(function()
        {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Temporal', 'EricLagarda\Temporal\Facades\Temporal');
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {

        return true;
    }

    private function handleConfigs() {

        $configPath = __DIR__ . '/../config/packagename.php';

        $this->publishes([$configPath => config_path('packagename.php')]);

        $this->mergeConfigFrom($configPath, 'packagename');
    }

    private function handleMigrations() {

        $this->publishes([__DIR__ . '/../migrations' => base_path('database/migrations')]);
    }

}
