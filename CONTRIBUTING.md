# 贡献指南

感谢您考虑为 Country Accept Language 包做出贡献！

## 开发环境设置

1. Fork 并克隆仓库
2. 运行 `composer install` 安装依赖
3. 运行 `composer test` 确保所有测试通过

## 开发流程

1. 创建一个新分支：`git checkout -b my-feature-branch`
2. 进行更改
3. 运行测试：`composer test`
4. 格式化代码：`composer format`
5. 提交更改：`git commit -am 'Add some feature'`
6. 推送到分支：`git push origin my-feature-branch`
7. 提交 Pull Request

## 测试

所有新功能和修复都应该包含测试。我们使用 Pest 测试框架。

```bash
composer test
```

## 代码风格

我们使用 Laravel Pint 来保持一致的代码风格。在提交之前，请运行：

```bash
composer format
```

## Pull Request 指南

- 更新 README.md 以反映任何更改
- 版本号遵循 [SemVer](http://semver.org/)
- 确保所有测试通过
- 保持 PR 尽可能小，专注于单一功能或修复

## 行为准则

请尊重所有贡献者和用户。我们希望维护一个友好、包容的社区。
