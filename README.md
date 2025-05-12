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

### 自定义数据

默认情况下，包会使用自带的国家语言映射数据。如果您希望自定义或修改这些数据：

1.  **发布数据文件**：
    运行以下命令，将包内的数据文件 `country-language.php` 复制到您应用的 `resources/data/` 目录下：

    ```bash
    php artisan vendor:publish --provider="Weijiajia\CountryAcceptLanguage\CountryAcceptLanguageServiceProvider" --tag="data"
    # 或者如果服务提供者已自动发现，可以简化为：
    # php artisan vendor:publish --tag="data"
    ```

    发布后，您可以在 `resources/data/country-language.php` 文件中修改映射关系。

2.  **配置数据文件路径（重要）**：
    仅仅发布数据文件并不会让应用自动使用它。您需要告诉应用去加载这个新发布的文件。为此，您需要在 Laravel 应用的配置文件中（例如，您可以创建一个 `config/country-accept-language.php` 文件）指定 `data_file` 的路径：

    ```php
    // config/country-accept-language.php
    <?php

    return [
        'data_file' => resource_path('data/country-language.php'),
    ];
    ```

    如果未进行此配置，包将继续使用其内部的默认数据文件。

## 使用方法

### 在 Laravel 中使用

使用 Facade：

```php
use Weijiajia\CountryAcceptLanguage\Facades\CountryAcceptLanguage;
use Weijiajia\CountryAcceptLanguage\Exception\CountryNotFoundException;

try {
    // 获取美国的 Accept-Language 头部
    $headerUS = CountryAcceptLanguage::getAcceptLanguageHeader('US');
    // 返回: "en-US,en;q=0.9"

    // 获取中国的 Accept-Language 头部
    $headerCN = CountryAcceptLanguage::getAcceptLanguageHeader('CN');
    // 返回: "zh-CN,zh;q=0.9,en;q=0.8"

    // 获取一个不存在的国家代码会抛出异常
    // $headerInvalid = CountryAcceptLanguage::getAcceptLanguageHeader('XX');

    // 获取所有支持的国家代码 (基于加载的数据文件)
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
} catch (CountryNotFoundException $e) {
    // 处理国家代码未找到的情况
    echo "Error: " . $e->getMessage();
}
```

通过依赖注入：

```php
use Weijiajia\CountryAcceptLanguage\CountryAcceptLanguage;
use Weijiajia\CountryAcceptLanguage\DataRepository;

// 默认使用包内数据
// $service = new CountryAcceptLanguage(new DataRepository());

// 使用指定路径的数据文件
$customDataPath = '/path/to/your/custom-country-language.php';
$service = new CountryAcceptLanguage(new DataRepository($customDataPath));

$header = $service->getAcceptLanguageHeader('US');
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
