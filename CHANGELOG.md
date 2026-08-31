# Changelog

All notable changes to `remote-cli` will be documented in this file.

The 0.0.x entries below are inherited from
[spatie/global-laravel-remote](https://github.com/spatie/global-laravel-remote), the package this
one was forked from. Their links point at that repository.

## Unreleased

### Changed

- Renamed to `enricodelazzari/remote-cli`; the command is now `remote-cli`. The hosts file stays at
  `~/.laravel-remote.json`, so nothing has to be reconfigured.
- Requires PHP 8.3 and runs on Laravel Zero 13. The previous release was built on Laravel 10.
- Installed copies no longer expose Laravel Zero's `app:build`, `make:*` and `test` commands.
- `--version` reports the version Composer installed instead of shelling out to `git describe` on
  every run.

### Added

- A `hosts` command, listing what is configured and where it is stored.
- Jump host support, as a `--jump` option and as a per-host setting.
- A per-host PHP binary and SSH private key, both already supported by spatie/laravel-remote but
  never asked for.
- `REMOTE_CONFIG_PATH`, to keep the hosts somewhere other than the home directory.

### Fixed

- Running the test suite no longer deletes the hosts of whoever runs it.

### Removed

- The 24 MB build artifact that was committed in March 2024 and shipped with every install.

## 0.0.4 - 2024-02-27

### What's Changed

* chore(deps): bump dependabot/fetch-metadata from 1.3.4 to 1.3.5 by @dependabot in https://github.com/spatie/global-laravel-remote/pull/2
* chore(deps): bump dependabot/fetch-metadata from 1.3.5 to 1.3.6 by @dependabot in https://github.com/spatie/global-laravel-remote/pull/5
* chore(deps): bump dependabot/fetch-metadata from 1.3.6 to 1.4.0 by @dependabot in https://github.com/spatie/global-laravel-remote/pull/7
* chore(deps): bump dependabot/fetch-metadata from 1.4.0 to 1.5.1 by @dependabot in https://github.com/spatie/global-laravel-remote/pull/8
* chore(deps): bump dependabot/fetch-metadata from 1.5.1 to 1.6.0 by @dependabot in https://github.com/spatie/global-laravel-remote/pull/10
* chore(deps): bump stefanzweifel/git-auto-commit-action from 4 to 5 by @Nielsvanpach in https://github.com/spatie/global-laravel-remote/pull/14

### New Contributors

* @dependabot made their first contribution in https://github.com/spatie/global-laravel-remote/pull/2
* @Nielsvanpach made their first contribution in https://github.com/spatie/global-laravel-remote/pull/14

**Full Changelog**: https://github.com/spatie/global-laravel-remote/compare/0.0.3...0.0.4

## 0.0.3 - 2022-11-01

**Full Changelog**: https://github.com/spatie/global-laravel-remote/compare/0.0.2...0.0.3

## 0.0.2 - 2022-10-30

**Full Changelog**: https://github.com/spatie/global-laravel-remote/compare/0.0.1...0.0.2

## 0.0.1 - 2022-10-28

### What's Changed

- Fix does not contain valid JSON by @Kristories in https://github.com/spatie/global-laravel-remote/pull/1

### New Contributors

- @Kristories made their first contribution in https://github.com/spatie/global-laravel-remote/pull/1

**Full Changelog**: https://github.com/spatie/global-laravel-remote/commits/0.0.1
