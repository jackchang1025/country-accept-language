# Country Accept Language 测试文档

本目录包含使用 Pest 测试框架的 Country Accept Language 包的测试文件。该包支持 Laravel 框架，提供基于国家代码的 Accept-Language 头部字符串。

## 运行测试

首先，安装依赖：

```bash
composer install
```

然后，运行测试：

```bash
composer test
```

或者直接使用 Pest：

```bash
./vendor/bin/pest
```

## 测试覆盖率

要生成测试覆盖率报告，请运行：

```bash
composer test-coverage
```

## 代码格式化

使用 Laravel Pint 格式化代码：

```bash
composer format
```

## 测试结构

- `Unit/`: 包含单元测试
  - `DataRepositoryTest.php`: 测试 `DataRepository` 类
  - `CountryAcceptLanguageTest.php`: 测试 `CountryAcceptLanguage` 类
  - `Exception/CountryNotFoundExceptionTest.php`: 测试 `CountryNotFoundException` 类
- `Feature/`: 包含功能测试
  - `CountryAcceptLanguageFeatureTest.php`: 测试完整工作流程
- `Laravel/`: 包含 Laravel 集成测试
  - `ServiceProviderTest.php`: 测试 Laravel 服务提供者
  - `FacadeTest.php`: 测试 Laravel Facade
- `resources/`: 包含测试资源
  - `test-country-language.php`: 测试数据

## 测试助手函数

`Pest.php` 文件包含以下测试助手函数：

- `getTestDataFilePath()`: 返回测试数据文件路径
- `createTestDataFile()`: 创建测试数据文件
- `cleanupTestDataFile()`: 清理测试数据文件

## Laravel 测试

Laravel 集成测试使用 Orchestra Testbench 包来模拟 Laravel 环境。这些测试验证了该包是否正确集成到 Laravel 应用程序中。

## 持续集成

本项目配置了 GitHub Actions 工作流，在每次推送和拉取请求时自动运行测试。
