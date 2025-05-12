<?php

use Weijiajia\CountryAcceptLanguage\CountryAcceptLanguage;
use Weijiajia\CountryAcceptLanguage\Exception\CountryNotFoundException;

test('can get accept language header for real countries', function () {
    $service = new CountryAcceptLanguage;

    // Test a few common countries
    expect($service->getAcceptLanguageHeader('US'))->toContain('en-US');
    expect($service->getAcceptLanguageHeader('CN'))->toContain('zh-CN');
    expect($service->getAcceptLanguageHeader('FR'))->toContain('fr-FR');
    expect($service->getAcceptLanguageHeader('DE'))->toContain('de-DE');
    expect($service->getAcceptLanguageHeader('JP'))->toContain('ja-JP');
});

test('throws exception for invalid country code', function () {
    $service = new CountryAcceptLanguage;

    expect(fn () => $service->getAcceptLanguageHeader('XX'))->toThrow(CountryNotFoundException::class);
    expect(fn () => $service->getAcceptLanguageHeader(''))->toThrow(CountryNotFoundException::class);
});

test('can get all supported countries', function () {
    $service = new CountryAcceptLanguage;
    $countries = $service->getSupportedCountries();

    expect($countries)->toBeArray();
    expect($countries)->toContain('US', 'CN', 'FR', 'DE', 'JP');
    expect(count($countries))->toBeGreaterThan(100); // Should have many countries
});

test('can parse preferred languages for real countries', function () {
    $service = new CountryAcceptLanguage;

    // Test US
    $usPreferences = $service->getPreferredLanguages('US');
    expect($usPreferences)->toBeArray();
    expect($usPreferences[0]['locale'])->toBe('en-US');
    expect($usPreferences[0]['language'])->toBe('en');
    expect($usPreferences[0]['region'])->toBe('US');

    // Test CN
    $cnPreferences = $service->getPreferredLanguages('CN');
    expect($cnPreferences)->toBeArray();
    expect($cnPreferences[0]['locale'])->toBe('zh-CN');
    expect($cnPreferences[0]['language'])->toBe('zh');
    expect($cnPreferences[0]['region'])->toBe('CN');

    // Test a multilingual country like Switzerland
    $chPreferences = $service->getPreferredLanguages('CH');
    expect($chPreferences)->toBeArray();
    expect($chPreferences)->toHaveCount(7); // Should have multiple languages
    expect($chPreferences[0]['locale'])->toBe('de-CH');
    expect($chPreferences[1]['locale'])->toBe('fr-CH');
    expect($chPreferences[2]['locale'])->toBe('it-CH');
});
