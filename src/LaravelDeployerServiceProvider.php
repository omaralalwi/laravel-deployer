<?php

namespace Omaralalwi\LaravelDeployer;

use Illuminate\Support\ServiceProvider;
use Omaralalwi\LaravelDeployer\Enums\Keys;
use Omaralalwi\LaravelDeployer\Services\ConfigurationReader;
use Omaralalwi\LaravelDeployer\Services\CommandExecutor;
use Omaralalwi\LaravelDeployer\Services\DeploymentManager;
use Omaralalwi\LaravelDeployer\Console\Commands\DeployCommand;
use Omaralalwi\LaravelDeployer\Console\Commands\GenerateSshKey;

class LaravelDeployerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path(Keys::CONFIG_FILE.'.php'),
            ], Keys::CONFIG_FILE.'-config');

             $this->commands([
                 DeployCommand::class,
                 GenerateSshKey::class
             ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', Keys::CONFIG_FILE);

        $this->app->singleton(ConfigurationReader::class, function ($app) {
            return new ConfigurationReader();
        });

        $this->app->singleton(CommandExecutor::class, function ($app) {
            return new CommandExecutor();
        });

        $this->app->singleton(DeploymentManager::class, function ($app) {
            return new DeploymentManager(
                $app->make(ConfigurationReader::class),
                $app->make(CommandExecutor::class)
            );
        });

    }
}
