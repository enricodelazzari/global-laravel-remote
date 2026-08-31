<?php

use App\Support\ConfigRepository;

it('stores the hosts outside of the real config file while testing', function () {
    expect(hosts()->path())
        ->not->toBe(ConfigRepository::defaultPath())
        ->toStartWith(sys_get_temp_dir());
});

it('falls back to the config file in the home directory', function () {
    expect(ConfigRepository::defaultPath())->toEndWith('/.laravel-remote.json');
});

it('can store and forget an host', function () {
    $config = createDefaultHost(['host' => 'example.com']);

    expect($config->default)->toBeArray();
    expect($config->default)
        ->host->toBe('example.com')
        ->user->toBe('root')
        ->port->toBe(22)
        ->path->toBe('/');

    $config->forgetHost('default');
    expect($config->default)->toBeNull();
});

it('can flush all hosts', function () {
    $config = hosts();

    $config->setHost('example1', ['host' => 'example1.com', 'user' => 'root', 'port' => 22, 'path' => '/']);
    $config->setHost('example2', ['host' => 'example2.com', 'user' => 'root', 'port' => 22, 'path' => '/']);

    $config->flush();

    expect($config->all())->toHaveCount(0);
});

it('can check if an host exists', function () {
    $config = createDefaultHost();

    expect($config->has('default'))->toBeTrue();
    expect($config->has('missing'))->toBeFalse();
});
