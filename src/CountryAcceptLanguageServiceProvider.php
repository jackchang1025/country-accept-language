<?php

namespace Weijiajia\CountryAcceptLanguage;

use Illuminate\Support\ServiceProvider;

class CountryAcceptLanguageServiceProvider extends ServiceProvider
{
    /**
     * 注册服务
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/country-accept-language.php', 'country-accept-language'
        );

        $this->app->singleton(CountryAcceptLanguage::class, function ($app) {
            return new CountryAcceptLanguage(
                new DataRepository(config('country-accept-language.data_file'))
            );
        });
    }

    /**
     * 引导服务
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {

            $this->publishes([
                __DIR__ . '/config/country-accept-language.php' => config_path('country-accept-language.php'),
            ], 'config');

            $this->publishes([
                __DIR__.'/resources/country-language.php' => resource_path('data/country-language.php'),
            ], 'data');

        }
    }
}
