<?php

namespace Weijiajia\CountryAcceptLanguage\Tests\Laravel;

use Orchestra\Testbench\TestCase;
use Weijiajia\CountryAcceptLanguage\CountryAcceptLanguageServiceProvider;
use Weijiajia\CountryAcceptLanguage\Facades\CountryAcceptLanguage;

class FacadeTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            CountryAcceptLanguageServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'CountryAcceptLanguage' => CountryAcceptLanguage::class,
        ];
    }

    public function test_facade_works()
    {
        $this->assertContains('US', CountryAcceptLanguage::getSupportedCountries());
    }

    public function test_get_accept_language_header()
    {
        $header = CountryAcceptLanguage::getAcceptLanguageHeader('US');
        $this->assertEquals('en-US,en;q=0.9', $header);
    }

    public function test_get_preferred_languages()
    {
        $languages = CountryAcceptLanguage::getPreferredLanguages('US');

        $this->assertIsArray($languages);
        $this->assertCount(2, $languages);
        $this->assertEquals('en-US', $languages[0]['locale']);
    }
}
