<?php

namespace Weijiajia\CountryAcceptLanguage\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string getAcceptLanguageHeader(string $countryCode)
 * @method static array getSupportedCountries()
 * @method static array getPreferredLanguages(string $countryCode)
 *
 * @see \Weijiajia\CountryAcceptLanguage\CountryAcceptLanguage
 */
class CountryAcceptLanguage extends Facade
{
    /**
     * 获取Facade注册名称
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Weijiajia\CountryAcceptLanguage\CountryAcceptLanguage::class;
    }
}
