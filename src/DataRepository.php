<?php

namespace Weijiajia\CountryAcceptLanguage;

class DataRepository
{
    private array $data = [];

    private string $dataFile;

    public function __construct(?string $dataFile = null)
    {
        $this->dataFile = $dataFile ?: __DIR__.'/resources/country-language.php';
        $this->loadData();
    }

    private function loadData(): void
    {
        if (! file_exists($this->dataFile)) {
            $this->data = [];

            return;
        }
        $this->data = require $this->dataFile;
    }

    public function findByCountryCode(string $countryCode): ?string
    {
        return $this->data[strtoupper($countryCode)] ?? null;
    }

    public function getAllCountryCodes(): array
    {
        return array_keys($this->data);
    }

    public function getAllData(): array
    {
        return $this->data;
    }
}
