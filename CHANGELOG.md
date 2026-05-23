# Changelog

## [1.2.1] - 2026-05-23

### Security
- Bumped `symfony/*` packages to v7.4.12 in `composer.lock` to patch CVE-2026-45065, CVE-2026-45067, CVE-2026-45068, CVE-2026-45070, CVE-2026-45075, CVE-2026-45133, CVE-2026-45304, CVE-2026-45305 (incorrect authorization in `http-kernel`, URL bypass in `routing`, header injection in `mime`/`mailer`, YAML parser DoS).

## [1.2.0] - 2026-03-28

### Added
- Laravel 13 support

### Changed
- Minimum PHP version lowered to 8.2

## [1.1.1] - Previous release

## [1.1.0] - Previous release

## [1.0.0] - Initial release

### Added
- Temporary Gate authorization bypass for developers
- Time-limited, IP-restricted access
- Artisan commands for enable/disable
- Programmatic API via DevModeService
- Auto-discovered service provider
- Configurable TTL
