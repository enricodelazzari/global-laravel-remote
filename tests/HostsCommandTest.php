<?php

use App\Commands\HostsCommand;

it('says so when there are no hosts', function () {
    $this->artisan(HostsCommand::class)
        ->expectsOutputToContain('There are no hosts created')
        ->assertOk();
});

it('lists the configured hosts and where they are stored', function () {
    createDefaultHost();

    hosts()->setHost('staging', [
        'host' => 'staging.laravel.com',
        'user' => 'forge',
        'port' => 22,
        'path' => '/home/forge/staging',
    ]);

    // One substring per line: each of these has to land on a different row.
    $this->artisan(HostsCommand::class)
        ->expectsOutputToContain('default')
        ->expectsOutputToContain('staging.laravel.com')
        ->expectsOutputToContain(hosts()->path())
        ->assertOk();
});

it('only shows the optional columns that are in use', function () {
    createDefaultHost(['jump' => 'forge@bastion.com']);

    $this->artisan(HostsCommand::class)
        ->expectsOutputToContain('Jump host')
        ->doesntExpectOutputToContain('SSH key')
        ->assertOk();
});
