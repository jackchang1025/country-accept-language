<?php

namespace Weijiajia\CountryAcceptLanguage\Tests\Laravel;

use Orchestra\Testbench\TestCase;
use Weijiajia\CountryAcceptLanguage\CountryAcceptLanguage;
use Weijiajia\CountryAcceptLanguage\CountryAcceptLanguageServiceProvider;

class ServiceProviderTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            CountryAcceptLanguageServiceProvider::class,
        ];
    }

    public function test_service_is_registered()
    {
        $this->assertTrue($this->app->bound(CountryAcceptLanguage::class));
    }

    public function test_config_is_published()
    {
        $this->artisan('vendor:publish', [
            '--provider' => CountryAcceptLanguageServiceProvider::class,
            '--tag' => 'config',
        ]);

        $this->assertFileExists(config_path('country-accept-language.php'));
    }

    public function test_data_is_published()
    {
        $this->artisan('vendor:publish', [
            '--provider' => CountryAcceptLanguageServiceProvider::class,
            '--tag' => 'data',
        ]);

        $this->assertFileExists(resource_path('data/country-language.php'));
    }

    public function test_service_works()
    {
        $service = $this->app->make(CountryAcceptLanguage::class);

        $this->assertInstanceOf(CountryAcceptLanguage::class, $service);
        $this->assertContains('US', $service->getSupportedCountries());
    }
}
