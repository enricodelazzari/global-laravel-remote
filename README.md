# Execute artisan commands on your server

[![Latest Version on Packagist](https://img.shields.io/packagist/v/enricodelazzari/remote-cli.svg?style=flat-square)](https://packagist.org/packages/enricodelazzari/remote-cli)
[![GitHub Tests Action Status](https://github.com/enricodelazzari/global-laravel-remote/actions/workflows/run-tests.yml/badge.svg)](https://github.com/enricodelazzari/global-laravel-remote/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://github.com/enricodelazzari/global-laravel-remote/actions/workflows/fix-php-code-style-issues.yml/badge.svg)](https://github.com/enricodelazzari/global-laravel-remote/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/enricodelazzari/remote-cli.svg?style=flat-square)](https://packagist.org/packages/enricodelazzari/remote-cli)

This tool runs artisan commands on a remote server over SSH. It is
[spatie/laravel-remote](https://github.com/spatie/laravel-remote) as a standalone CLI: your servers
are kept in a file in your home directory instead of in a project's config, so you can reach any of
them from anywhere, without adding a dependency to the project itself.

```bash
remote-cli 'migrate --force' --host=production
```

Behind the scenes that connects over SSH, changes into the configured directory and runs
`php artisan migrate --force`, streaming the output back to your terminal.

> This is a maintained fork of [spatie/global-laravel-remote](https://github.com/spatie/global-laravel-remote),
> which has had no release since February 2024. See [Origins](#origins) for what changed and why.

## Installation

You can install the tool via composer:

```bash
composer global require enricodelazzari/remote-cli
```

Make sure Composer's global `bin` directory is on your `PATH`. You can find it with
`composer global config bin-dir --absolute`.

Alternatively, run it without installing it at all with [cpx](https://github.com/laravel/cpx):

```bash
cpx enricodelazzari/remote-cli 'migrate --force'
```

## Usage

Run a command by passing it as a single argument:

```bash
remote-cli 'migrate --force'
```

The first time you do this there are no hosts yet, so you'll be asked to create one. After that
you'll be asked which of your hosts to run on. Pick one up front to skip the question:

```bash
remote-cli 'queue:restart' --host=production
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
remote-cli 'git pull && composer install --no-dev' --raw --host=production
```

### Managing hosts

```bash
remote-cli hosts          # list what's configured, and where it's stored
remote-cli forget staging # remove one host
remote-cli flush          # remove all of them
```

A host is made of an alias, a hostname, a port, an SSH user and the path to the codebase on the
server. When you create one you can also set three optional things:

- **PHP binary** — for servers where artisan needs a specific PHP, e.g. `/usr/bin/php8.3`.
- **SSH key** — the path to a private key, for when your agent doesn't already offer the right one.
- **Jump host** — a bastion to connect through.

A stored jump host is used for every command against that host. `--jump` overrides it for a single
run, and `--jump=''` skips it for a single run.

### Where the hosts are stored

Hosts live in `.laravel-remote.json` in your home directory — the same file the original package
used, so switching over keeps the hosts you already had. Set `REMOTE_CONFIG_PATH` to keep them
somewhere else:

```bash
REMOTE_CONFIG_PATH=~/work/hosts.json remote-cli hosts
```

## Origins

This is a fork of [spatie/global-laravel-remote](https://github.com/spatie/global-laravel-remote).
That package was last released in February 2024 and its README was never filled in past the
skeleton's placeholder text. The fork exists to keep the tool working on current PHP and Laravel,
and it carries these changes:

- Runs on PHP 8.3+ with Laravel Zero 13, instead of Laravel 10, which has reached end of life.
- Fixes a bug where running the test suite deleted the hosts of whoever ran it.
- Stops installed copies from exposing Laravel Zero's `make:*` and `app:build` commands.
- Drops a stale 24 MB build artifact that shipped with every install.
- Adds a `hosts` command, jump host support, and per-host PHP binary and SSH key.

The stored hosts file is unchanged, so you can install this alongside or instead of the original.
The command is named `remote-cli` rather than `global-laravel-remote`, so having both installed
does not clash.

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

- [Enrico Delazzari](https://github.com/enricodelazzari)
- [Francisco Madeira](https://github.com/xiCO2k) and [Freek Van der Herten](https://github.com/freekmurze),
  who wrote the original package at [Spatie](https://spatie.be)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
