# Execute artisan commands on your server

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/global-laravel-remote.svg?style=flat-square)](https://packagist.org/packages/spatie/global-laravel-remote)
[![GitHub Tests Action Status](https://github.com/spatie/global-laravel-remote/actions/workflows/run-tests.yml/badge.svg)](https://github.com/spatie/global-laravel-remote/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://github.com/spatie/global-laravel-remote/actions/workflows/fix-php-code-style-issues.yml/badge.svg)](https://github.com/spatie/global-laravel-remote/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/global-laravel-remote.svg?style=flat-square)](https://packagist.org/packages/spatie/global-laravel-remote)

This tool runs artisan commands on a remote server over SSH. It is
[spatie/laravel-remote](https://github.com/spatie/laravel-remote) as a standalone CLI: your servers
are kept in a file in your home directory instead of in a project's config, so you can reach any of
them from anywhere, without adding a dependency to the project itself.

```bash
global-laravel-remote 'migrate --force' --host=production
```

Behind the scenes that connects over SSH, changes into the configured directory and runs
`php artisan migrate --force`, streaming the output back to your terminal.

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/global-laravel-remote.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/global-laravel-remote)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the tool via composer:

```bash
composer global require spatie/global-laravel-remote
```

Make sure Composer's global `bin` directory is on your `PATH`. You can find it with
`composer global config bin-dir --absolute`.

Alternatively, run it without installing it at all with [cpx](https://github.com/laravel/cpx):

```bash
cpx spatie/global-laravel-remote 'migrate --force'
```

## Usage

Run a command by passing it as a single argument:

```bash
global-laravel-remote 'migrate --force'
```

The first time you do this there are no hosts yet, so you'll be asked to create one. After that
you'll be asked which of your hosts to run on. Pick one up front to skip the question:

```bash
global-laravel-remote 'queue:restart' --host=production
```

Passing a `--host` you haven't created yet offers to create it under that alias.

### Options

| Option | What it does |
| --- | --- |
| `--host=` | The alias of the host to run on. You'll be asked to pick one when it's left out. |
| `--raw` | Run the command as given, instead of prefixing it with `php artisan`. |
| `--debug` | Print the SSH command that would run, and don't run it. |
| `--jump=` | Connect through a bastion, e.g. `--jump=forge@bastion.laravel.com`. |

`--raw` is what you want for anything that isn't artisan:

```bash
global-laravel-remote 'git pull && composer install --no-dev' --raw --host=production
```

### Managing hosts

```bash
global-laravel-remote hosts          # list what's configured, and where it's stored
global-laravel-remote forget staging # remove one host
global-laravel-remote flush          # remove all of them
```

A host is made of an alias, a hostname, a port, an SSH user and the path to the codebase on the
server. When you create one you can also set three optional things:

- **PHP binary** — for servers where artisan needs a specific PHP, e.g. `/usr/bin/php8.3`.
- **SSH key** — the path to a private key, for when your agent doesn't already offer the right one.
- **Jump host** — a bastion to connect through.

A stored jump host is used for every command against that host. `--jump` overrides it for a single
run, and `--jump=''` skips it for a single run.

### Where the hosts are stored

Hosts live in `.laravel-remote.json` in your home directory. Set `REMOTE_CONFIG_PATH` to keep them
somewhere else:

```bash
REMOTE_CONFIG_PATH=~/work/hosts.json global-laravel-remote hosts
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Francisco Madeira](https://github.com/xiCO2k)
- [Freek Van der Herten](https://github.com/freekmurze)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
