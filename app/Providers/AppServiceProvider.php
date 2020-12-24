<?php

namespace App\Providers;

use STS\SnapThis\Client;
use STS\SnapThis\Facades\SnapThis;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('zipstream.s3client', function ($app) {
            return \Storage::disk('s3')->getDriver()->getAdapter()->getClient();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        SnapThis::setDefaults(function(Client $snap)
        {
            $snap->hideBackground()->windowSize(1920, 1080)->lifetime(30 * 24 * 60 * 60);
        });
    }
}
