# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/),
and this project adheres to [Semantic Versioning](https://semver.org/).

## [Unreleased]

## [1.2.0] - 2020-11-20

### Changed

- 調整 `SlackServiceProvider` 的註冊方式，使用 `register` 在啟動時就註冊，避免發生前期 exception 時，找不到 `slack` 實體的問題

---

[Unreleased]: https://github.com/Fred07/laravel-slack/compare/1.2.0...master
[1.2.0]: https://github.com/Fred07/laravel-slack/compare/1.1.0...1.2.0
