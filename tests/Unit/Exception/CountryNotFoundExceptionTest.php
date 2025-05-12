<?php

use Weijiajia\CountryAcceptLanguage\Exception\CountryNotFoundException;

test('exception has correct message', function () {
    $exception = new CountryNotFoundException('XX');

    expect($exception->getMessage())->toBe('Country code "XX" not found in the dataset.');
});

test('exception has correct code', function () {
    $exception = new CountryNotFoundException('XX');

    expect($exception->getCode())->toBe(0);
});

test('exception can have previous exception', function () {
    $previous = new \Exception('Previous exception');
    $exception = new CountryNotFoundException('XX', $previous);

    expect($exception->getPrevious())->toBe($previous);
});
