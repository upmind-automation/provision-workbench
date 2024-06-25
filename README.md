# Upmind Provision Workbench

[![Latest Version on Packagist](https://img.shields.io/packagist/v/upmind/provision-workbench.svg?style=flat-square)](https://packagist.org/packages/upmind/provision-workbench)

A simple web application which provides a UI for quick and easy testing of Upmind provision providers.

- [Requirements](#requirements)
- [Installation](#installation)
  - [Docker (Recommended)](#using-makefile)
  - [Locally](#install-locally)
- [Development Quick-start](#development-quick-start)
- [Usage](#usage)
  - [Screenshots](#screenshots)
- [Changelog](#changelog)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)
- [Upmind](#upmind)

## Requirements

To install and run the workbench using Docker via Makefile (recommended) you will need:

- Git
- Docker

To install and run the workbench manually (not recommended) you will need:

- PHP ^8.1
- Composer

## Installation

**This project is intended to be used as a local development tool only and should NOT be hosted on the internet**

### Using Makefile

Clone git repository:

```bash
git clone https://github.com/upmind-automation/provision-workbench.git && cd provision-workbench
```

Build and run container (first build may take a few minutes):

```bash
make setup
```

You'll then be able to access the workbench in a web browser at http://127.0.0.1:8000.

Connect to container (for artisan, composer etc):

```bash
make shell
```

Re-cache provision registry (e.g., after adding a new provider or updating data set rules):

```bash
make provision-cache
```

Stop container:

```bash
make stop
```

Remove container and image:

```bash
make clean
```

<details><summary><h4>Install Locally</h4></summary>

### Install Locally

- Requires PHP ^8.1 and composer

Create project:

```bash
composer create-project upmind/provision-workbench --keep-vcs
```

Run application:

```bash
php artisan serve
```

</details>

## Development Quick-start

Install a provision category + providers e.g., shared-hosting:

```bash
composer require upmind/provision-provider-shared-hosting
```

Refresh provision registry (e.g., after adding a new provider or updating data set rules):

```bash
php artisan upmind:provision:cache
```

Install a package locally:

```bash
git clone https://github.com/upmind-automation/provision-provider-domain-names.git local/domain-names \
  && composer require upmind/provision-provider-domain-names:@dev

```

## Usage

This library makes use of [upmind/provision-provider-base](https://packagist.org/packages/upmind/provision-provider-base) primitives which we suggest you familiarize yourself with by reading the usage section in the README.

<details><summary><h3>Screenshots</h3></summary>

#### Homepage

![Homepage](docs/images/home.png "Homepage")


#### Provision Categories

![Provision Categories](docs/images/provision_categories.png "Provision Categories")

#### Shared Hosting Providers

![Shared Hosting Providers](docs/images/shared_hosting_providers.png "Shared Hosting Providers")

#### New 20i Configuration

![New 20i Configuration](docs/images/new_20i_configuration.png "New 20i Configuration")

#### New Provision Request

![New Provision Request](docs/images/get_info_request.png "New Provision Request")

#### Provision Result

![Provision Result](docs/images/get_info_result.png "Provision Result")

#### Provision Result Data

![Provision Result Data](docs/images/get_info_result_data.png "Provision Result Data")

#### Provision Result Logs

![Provision Result Logs](docs/images/get_info_result_logs.png "Provision Result Logs")

#### List Provision Requests

![List Provision Requests](docs/images/list_provision_requests.png "List Provision Requests")
</details>

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
