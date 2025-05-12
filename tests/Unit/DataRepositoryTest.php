<?php

use Weijiajia\CountryAcceptLanguage\DataRepository;

beforeEach(function () {
    createTestDataFile();
});

afterEach(function () {
    cleanupTestDataFile();
});

test('can load data from file', function () {
    $repository = new DataRepository(getTestDataFilePath());

    expect($repository->getAllData())->toBeArray()
        ->toHaveCount(5)
        ->toHaveKeys(['US', 'CN', 'FR', 'DE', 'JP']);
});

test('can find language by country code', function () {
    $repository = new DataRepository(getTestDataFilePath());

    expect($repository->findByCountryCode('US'))->toBe('en-US,en;q=0.9');
    expect($repository->findByCountryCode('CN'))->toBe('zh-CN,zh;q=0.9,en;q=0.8');
    expect($repository->findByCountryCode('FR'))->toBe('fr-FR,fr;q=0.9,en;q=0.8');
});

test('returns null for non-existent country code', function () {
    $repository = new DataRepository(getTestDataFilePath());

    expect($repository->findByCountryCode('XX'))->toBeNull();
});

test('country code is case-insensitive', function () {
    $repository = new DataRepository(getTestDataFilePath());

    expect($repository->findByCountryCode('us'))->toBe('en-US,en;q=0.9');
    expect($repository->findByCountryCode('cn'))->toBe('zh-CN,zh;q=0.9,en;q=0.8');
});

test('can get all country codes', function () {
    $repository = new DataRepository(getTestDataFilePath());

    expect($repository->getAllCountryCodes())->toBeArray()
        ->toHaveCount(5)
        ->toContain('US', 'CN', 'FR', 'DE', 'JP');
});

test('returns empty array when data file does not exist', function () {
    cleanupTestDataFile(); // Make sure the file doesn't exist

    $repository = new DataRepository(getTestDataFilePath());

    expect($repository->getAllData())->toBeArray()->toBeEmpty();
    expect($repository->getAllCountryCodes())->toBeArray()->toBeEmpty();
    expect($repository->findByCountryCode('US'))->toBeNull();
});
