<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

// uses(Tests\TestCase::class)->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function getTestDataFilePath(): string
{
    return __DIR__.'/resources/test-country-language.php';
}

function createTestDataFile(): void
{
    $testData = [
        'US' => 'en-US,en;q=0.9',
        'CN' => 'zh-CN,zh;q=0.9,en;q=0.8',
        'FR' => 'fr-FR,fr;q=0.9,en;q=0.8',
        'DE' => 'de-DE,de;q=0.9,en;q=0.8',
        'JP' => 'ja-JP,ja;q=0.9,en;q=0.8',
    ];

    if (! is_dir(__DIR__.'/resources')) {
        mkdir(__DIR__.'/resources', 0755, true);
    }

    file_put_contents(getTestDataFilePath(), '<?php return '.var_export($testData, true).';');
}

function cleanupTestDataFile(): void
{
    if (file_exists(getTestDataFilePath())) {
        unlink(getTestDataFilePath());
    }
}
