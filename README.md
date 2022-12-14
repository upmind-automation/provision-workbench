# Upmind Provision Workbench

[![Latest Version on Packagist](https://img.shields.io/packagist/v/upmind/provision-workbench.svg?style=flat-square)](https://packagist.org/packages/upmind/provision-workbench)

A simple web application which provides a UI for quick and easy testing of Upmind provision providers.

- [Requirements](#requirements)
- [Installation](#installation)
  - [Quick-start](#quick-start)
- [Usage](#usage)
- [Changelog](#changelog)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)
- [Upmind](#upmind)

## Requirements

- PHP 7.4 or higher
- Composer

## Installation

**This project is intended to be used as a local development tool only and should NOT be hosted on the internet**

```bash
composer create-project upmind/provision-workbench --keep-vcs
```

### Quick-start

Run the application:

```bash
php artisan serve
```

Install a provision category + providers e.g., shared-hosting:

```bash
composer require upmind/provision-provider-shared-hosting
```

Refresh provision registry (e.g., after adding a new provider or updating data set rules):

```bash
php artisan upmind:provision:cache
```

## Usage

This library makes use of [upmind/provision-provider-base](https://packagist.org/packages/upmind/provision-provider-base) primitives which we suggest you familiarize yourself with by reading the usage section in the README.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

 - [Harry Lewis](https://github.com/uphlewis)
 - [All Contributors](../../contributors)

## License

GNU General Public License version 3 (GPLv3). Please see [License File](LICENSE.md) for more information.

## Upmind

Sell, manage and support web hosting, domain names, ssl certificates, website builders and more with [Upmind.com](https://upmind.com/start) - the ultimate web hosting billing and management solution.