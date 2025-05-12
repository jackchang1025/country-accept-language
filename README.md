# Country Accept Language

[![Tests](https://github.com/yourusername/country-accept-language/actions/workflows/tests.yml/badge.svg)](https://github.com/yourusername/country-accept-language/actions/workflows/tests.yml)
[![Latest Stable Version](https://poser.pugx.org/weijiajia/country-accept-language/v)](https://packagist.org/packages/weijiajia/country-accept-language)
[![Total Downloads](https://poser.pugx.org/weijiajia/country-accept-language/downloads)](https://packagist.org/packages/weijiajia/country-accept-language)
[![License](https://poser.pugx.org/weijiajia/country-accept-language/license)](https://packagist.org/packages/weijiajia/country-accept-language)

根据国家代码提供 Accept-Language 头部字符串的 Laravel 包。

## 功能特点

- 根据国家代码（ISO 3166-1 alpha-2）获取 Accept-Language 头部字符串
- 支持 200+ 个国家和地区
- 解析 Accept-Language 字符串为结构化数组
- 完全支持 Laravel 框架
- 提供方便的 Facade 接口

## 安装

通过 Composer 安装：

```bash
composer require weijiajia/country-accept-language
```

## Laravel 集成

该包支持 Laravel 的包自动发现功能，无需手动注册服务提供者。

如果您需要自定义配置，可以发布配置文件：

```bash
php artisan vendor:publish --provider="Weijiajia\CountryAcceptLanguage\CountryAcceptLanguageServiceProvider" --tag="config"
```

如果您想自定义国家语言数据，可以发布数据文件：

```bash
php artisan vendor:publish --provider="Weijiajia\CountryAcceptLanguage\CountryAcceptLanguageServiceProvider" --tag="data"
```

## 使用方法

### 在 Laravel 中使用

使用 Facade：

```php
use Weijiajia\CountryAcceptLanguage\Facades\CountryAcceptLanguage;

// 获取美国的 Accept-Language 头部
$header = CountryAcceptLanguage::getAcceptLanguageHeader('US');
// 返回: "en-US,en;q=0.9"

// 获取中国的 Accept-Language 头部
$header = CountryAcceptLanguage::getAcceptLanguageHeader('CN');
// 返回: "zh-CN,zh;q=0.9,en;q=0.8"

// 获取所有支持的国家代码
$countries = CountryAcceptLanguage::getSupportedCountries();

// 解析为结构化数组
$languages = CountryAcceptLanguage::getPreferredLanguages('CN');
/*
返回:
[
    [
        'locale' => 'zh-CN',
        'language' => 'zh',
        'region' => 'CN',
        'quality' => 1.0,
    ],
    [
        'locale' => 'zh',
        'language' => 'zh',
        'region' => null,
        'quality' => 0.9,
    ],
    [
        'locale' => 'en',
        'language' => 'en',
        'region' => null,
        'quality' => 0.8,
    ],
]
*/
```

通过依赖注入：

```php
use Weijiajia\CountryAcceptLanguage\CountryAcceptLanguage;

class YourController
{
    public function index(CountryAcceptLanguage $countryLanguage)
    {
        $header = $countryLanguage->getAcceptLanguageHeader('US');
        // ...
    }
}
```

### 在非 Laravel 项目中使用

```php
use Weijiajia\CountryAcceptLanguage\CountryAcceptLanguage;
use Weijiajia\CountryAcceptLanguage\DataRepository;

$service = new CountryAcceptLanguage(new DataRepository());
$header = $service->getAcceptLanguageHeader('US');
```

## 测试

```bash
composer test
```

## 贡献

欢迎贡献！请查看 [CONTRIBUTING.md](CONTRIBUTING.md) 了解详情。

## 许可证

MIT 许可证 (MIT)。请查看 [LICENSE](LICENSE) 了解详情。
