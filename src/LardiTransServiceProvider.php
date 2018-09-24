<?php

namespace MammutAlex\LardiTransLaravel;

use Illuminate\Support\ServiceProvider;

class LardiTransServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            $this->getConfigFile() => config_path('larditrans.php'),
        ]);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            $this->getConfigFile(), 'larditrans'
        );
        $this->app->singleton(LardiTrans::class, function ($app) {
            return new LardiTrans(config('larditrans'));
        });
    }

    protected function getConfigFile(): string
    {
        return __DIR__ . '/../config/larditrans.php';
    }
}
