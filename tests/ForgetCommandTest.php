<?php

use App\Commands\ForgetCommand;

it('removes an host when called the command', function () {
    $config = createDefaultHost();

    expect($config->default['host'])->toBe('example.com');

    $this->artisan(ForgetCommand::class, [
        'host' => 'default',
    ])->assertOk();

    expect($config->default)->toBeNull();
});

it('returns a failure if there is no host found', function () {
    $this->artisan(ForgetCommand::class, [
        'host' => 'default',
    ])->assertFailed();
});
