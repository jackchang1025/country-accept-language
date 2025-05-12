<?php

use Weijiajia\CountryAcceptLanguage\CountryAcceptLanguage;
use Weijiajia\CountryAcceptLanguage\DataRepository;
use Weijiajia\CountryAcceptLanguage\Exception\CountryNotFoundException;

beforeEach(function () {
    createTestDataFile();
});

afterEach(function () {
    cleanupTestDataFile();
});

test('can get accept language header', function () {
    $repository = new DataRepository(getTestDataFilePath());
    $service = new CountryAcceptLanguage($repository);

    expect($service->getAcceptLanguageHeader('US'))->toBe('en-US,en;q=0.9');
    expect($service->getAcceptLanguageHeader('CN'))->toBe('zh-CN,zh;q=0.9,en;q=0.8');
    expect($service->getAcceptLanguageHeader('FR'))->toBe('fr-FR,fr;q=0.9,en;q=0.8');
});

test('throws exception for non-existent country code', function () {
    $repository = new DataRepository(getTestDataFilePath());
    $service = new CountryAcceptLanguage($repository);

    expect(fn () => $service->getAcceptLanguageHeader('XX'))->toThrow(CountryNotFoundException::class);
});

test('can get supported countries', function () {
    $repository = new DataRepository(getTestDataFilePath());
    $service = new CountryAcceptLanguage($repository);

    expect($service->getSupportedCountries())->toBeArray()
        ->toHaveCount(5)
        ->toContain('US', 'CN', 'FR', 'DE', 'JP');
});

test('can parse preferred languages', function () {
    $repository = new DataRepository(getTestDataFilePath());
    $service = new CountryAcceptLanguage($repository);

    $preferences = $service->getPreferredLanguages('US');

    expect($preferences)->toBeArray()->toHaveCount(2);

    expect($preferences[0])->toBeArray()
        ->toHaveKeys(['locale', 'language', 'region', 'quality'])
        ->toMatchArray([
            'locale' => 'en-US',
            'language' => 'en',
            'region' => 'US',
            'quality' => 1.0,
        ]);

    expect($preferences[1])->toBeArray()
        ->toHaveKeys(['locale', 'language', 'region', 'quality'])
        ->toMatchArray([
            'locale' => 'en',
            'language' => 'en',
            'region' => null,
            'quality' => 0.9,
        ]);
});

test('can parse preferred languages with multiple entries', function () {
    $repository = new DataRepository(getTestDataFilePath());
    $service = new CountryAcceptLanguage($repository);

    $preferences = $service->getPreferredLanguages('CN');

    expect($preferences)->toBeArray()->toHaveCount(3);

    expect($preferences[0])->toBeArray()
        ->toMatchArray([
            'locale' => 'zh-CN',
            'language' => 'zh',
            'region' => 'CN',
            'quality' => 1.0,
        ]);

    expect($preferences[1])->toBeArray()
        ->toMatchArray([
            'locale' => 'zh',
            'language' => 'zh',
            'region' => null,
            'quality' => 0.9,
        ]);

    expect($preferences[2])->toBeArray()
        ->toMatchArray([
            'locale' => 'en',
            'language' => 'en',
            'region' => null,
            'quality' => 0.8,
        ]);
});

test('sorts preferred languages by quality', function () {
    // Create a custom repository with a specific order to test sorting
    $mockRepository = mock(DataRepository::class);
    $mockRepository->shouldReceive('findByCountryCode')
        ->with('TEST')
        ->andReturn('en;q=0.5,fr;q=0.9,es;q=0.7,zh;q=1.0');

    $service = new CountryAcceptLanguage($mockRepository);

    $preferences = $service->getPreferredLanguages('TEST');

    expect($preferences)->toBeArray()->toHaveCount(4);

    // Should be sorted by quality in descending order
    expect($preferences[0]['locale'])->toBe('zh');
    expect($preferences[0]['quality'])->toBe(1.0);

    expect($preferences[1]['locale'])->toBe('fr');
    expect($preferences[1]['quality'])->toBe(0.9);

    expect($preferences[2]['locale'])->toBe('es');
    expect($preferences[2]['quality'])->toBe(0.7);

    expect($preferences[3]['locale'])->toBe('en');
    expect($preferences[3]['quality'])->toBe(0.5);
});

test('handles locales with underscore separator', function () {
    $mockRepository = mock(DataRepository::class);
    $mockRepository->shouldReceive('findByCountryCode')
        ->with('TEST')
        ->andReturn('en_US,fr_FR;q=0.8');

    $service = new CountryAcceptLanguage($mockRepository);

    $preferences = $service->getPreferredLanguages('TEST');

    expect($preferences)->toBeArray()->toHaveCount(2);

    expect($preferences[0])->toMatchArray([
        'locale' => 'en_US',
        'language' => 'en',
        'region' => 'US',
        'quality' => 1.0,
    ]);

    expect($preferences[1])->toMatchArray([
        'locale' => 'fr_FR',
        'language' => 'fr',
        'region' => 'FR',
        'quality' => 0.8,
    ]);
});
