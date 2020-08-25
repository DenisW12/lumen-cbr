<?php

namespace App\Providers;

use App\Services\Currency\CurrenciesCbrService;
use App\Services\Currency\ICurrenciesService;
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
        $this->app->bind(
            ICurrenciesService::class,
            CurrenciesCbrService::class
        );
    }
}
