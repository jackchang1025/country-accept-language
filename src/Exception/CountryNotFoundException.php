<?php

namespace Weijiajia\CountryAcceptLanguage\Exception;

class CountryNotFoundException extends \RuntimeException
{
    public function __construct(string $countryCode, ?\Throwable $previous = null)
    {
        parent::__construct(sprintf('Country code "%s" not found in the dataset.', $countryCode), 0, $previous);
    }
}
