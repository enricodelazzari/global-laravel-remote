<?php

namespace App\Providers;

use App\Support\ConfigRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ConfigRepository::class, function ($app) {
            /** @var string|null $path */
            $path = $app->make('config')->get('remote.config_path');

            return new ConfigRepository($path);
        });
    }
}
