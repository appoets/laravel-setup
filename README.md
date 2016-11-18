# Laravel Web Setup Installer
Laravel Setup Wizard for 5.3

The current features are : 

	- Check For Server Requirements.
	- Check For Folders Permissions.
	- Ability to set database information.
	- Migrate The Database.
	- Seed The Tables.
  

## Installation

First, pull in the package through Composer.

```
composer require "appoets/laravel-setup-installer":"*"

```

After that, include the service provider within `config/app.php`.

```
'providers' => [
    Appoets\LaravelSetup\Providers\LaravelSetupServiceProvider::class,
];
```

## Usage

Before using this package you need to run :
```bash
php artisan vendor:publish --provider="Appoets\LaravelSetup\Providers\LaravelSetupServiceProvider"
```
