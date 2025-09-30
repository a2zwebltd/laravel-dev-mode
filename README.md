# Laravel Dev Mode Package

This package allows developers to temporarily bypass Laravel's authorization system (Gates) and gain full access for testing purposes. After a specified duration (default: 10 minutes), access is automatically revoked.

## Features
- Temporarily bypass Laravel Gates for selected developers
- Automatic revocation of access after a set time
- Manual enable/disable commands

## Requirements
- The `User` model must have an `is_developer` property (boolean)

## Installation

Install the package via Composer:

```bash
composer require a2zwebltd/laravel-dev-mode
```

Publish the migrations and config files:

```bash
php artisan vendor:publish --provider="A2ZWeb\DevMode\ServiceProvider"
```

Run the migrations:

```bash
php artisan migrate
```

## Usage

### Enable Dev Mode
Only users with `is_developer=true` can be enabled for dev mode.

Run the following command to enable dev mode for a developer:

```bash
php artisan dev-mode:enable --user={USER_ID} --ip={IP_OF_USER}
```


This will grant the specified user full access for the default duration (10 minutes).


#### Enable Dev Mode Programmatically
You can also enable dev mode directly in your code:

```php
$devMode = app(\A2ZWeb\DevMode\DevModeService::class);

$devMode->enable($user, $ip);
```

#### Adjusting Access Duration
You can change the duration of developer access by setting the `DEV_MODE_TTL` environment variable in your `.env` file. The value must be in seconds.

Example:
```env
DEV_MODE_TTL=600 # 10 minutes
```

### Automatic Revocation
After the duration expires, access is revoked automatically.

### Manual Revocation
To revoke access before the duration ends, run:

```bash
php artisan dev-mode:disable --user={USER_ID}
```

#### Disable Dev Mode Programmatically
You can also enable dev mode directly in your code:

```php
$devMode = app(\A2ZWeb\DevMode\DevModeService::class);

$devMode->disable($user);
```

## Security
- Only users with `is_developer=true` can be enabled for dev mode.
- Access is limited to the specified IP address.
