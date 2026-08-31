# Contributing

Contributions are welcome and will be fully credited. We accept contributions via pull requests on
[GitHub](https://github.com/spatie/global-laravel-remote).

## Getting set up

```bash
git clone https://github.com/spatie/global-laravel-remote
cd global-laravel-remote
composer install
```

You can run the tool straight from the checkout:

```bash
php global-laravel-remote hosts
```

An installed copy runs in the production environment, which hides Laravel Zero's development
commands. If you need `app:build` or `make:command`, put `APP_ENV=development` in a `.env` file in
the project root.

## Running the checks

```bash
composer test     # the test suite
composer analyse  # PHPStan
composer format   # Pint, fixes code style in place
```

The same three run in CI, so getting them green locally is the fastest way to a mergeable pull
request. Code style is fixed automatically on push, so don't worry about it too much.

## Writing tests

Every contribution needs a test, and every bug fix needs one that fails without the fix.

One rule matters more than the rest here: **the suite must never touch the real hosts file**. Tests
flush the hosts before each test, and flushing deletes the file, so a suite pointed at
`~/.laravel-remote.json` would wipe the hosts of whoever runs it. Always reach for the hosts through
the `hosts()` helper, which resolves the repository the container binds to a throwaway file — never
construct `ConfigRepository` directly in a test.

Prompts are answered with Laravel's console testing helpers:

```php
$this->artisan(GlobalRemoteCommand::class, ['rawCommand' => 'migrate'])
    ->expectsConfirmation('Would you like to create one?', 'yes')
    ->expectsQuestion('Provide the alias for your host', 'staging')
    ->run();
```

## Pull requests

- **One pull request per feature.** Open several if you want to do more than one thing.
- **Document behaviour changes.** Keep the README in step with what the tool does.
- **Consider our release cycle.** We follow [SemVer](https://semver.org). Don't break the public
  behaviour of the CLI on a whim.

**Happy coding!**
