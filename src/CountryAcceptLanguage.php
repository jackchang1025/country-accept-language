<?php

namespace Weijiajia\CountryAcceptLanguage;

use Weijiajia\CountryAcceptLanguage\Exception\CountryNotFoundException;

class CountryAcceptLanguage
{
    private DataRepository $repository;

    public function __construct(?DataRepository $repository = null)
    {
        $this->repository = $repository ?? new DataRepository;
    }

    /**
     * 获取指定国家代码的 Accept-Language 头部字符串。
     *
     * @param  string  $countryCode  ISO 3166-1 alpha-2 国家代码
     *
     * @throws CountryNotFoundException 如果国家代码未找到
     */
    public function getAcceptLanguageHeader(string $countryCode): string
    {
        $header = $this->repository->findByCountryCode($countryCode);
        if ($header === null) {
            throw new CountryNotFoundException($countryCode);
        }

        return $header;
    }

    /**
     * 获取支持的所有国家代码列表。
     *
     * @return string[]
     */
    public function getSupportedCountries(): array
    {
        return $this->repository->getAllCountryCodes();
    }

    /**
     * (高级功能示例) 解析 Accept-Language 字符串为结构化数组。
     *
     * @return array<int, array{locale: string, language: string, region: ?string, quality: float}>
     *
     * @throws CountryNotFoundException
     */
    public function getPreferredLanguages(string $countryCode): array
    {
        $headerString = $this->getAcceptLanguageHeader($countryCode);
        $preferences = [];
        $parts = explode(',', $headerString);

        foreach ($parts as $part) {
            $localePart = trim($part);
            $quality = 1.0;

            if (strpos($localePart, ';q=') !== false) {
                [$localePart, $qualityPart] = explode(';q=', $localePart);
                $quality = (float) $qualityPart;
            }

            $language = $localePart;
            $region = null;

            if (strpos($localePart, '-') !== false) {
                [$lang, $reg] = explode('-', $localePart, 2);
                $language = $lang;
                $region = $reg;
            } elseif (strpos($localePart, '_') !== false) { // 有些用下划线
                [$lang, $reg] = explode('_', $localePart, 2);
                $language = $lang;
                $region = $reg;
            }

            $preferences[] = [
                'locale' => $localePart,
                'language' => strtolower($language),
                'region' => $region ? strtoupper($region) : null,
                'quality' => $quality,
            ];
        }

        // 按 quality 降序排序
        usort($preferences, function ($a, $b) {
            return $b['quality'] <=> $a['quality'];
        });

        return $preferences;
    }
}
