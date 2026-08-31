<?php

use App\Commands\GlobalRemoteCommand;
use App\Support\ConfigRepository;
use Mockery as m;
use Spatie\Remote\Commands\RemoteCommand;
use Spatie\Remote\Config\RemoteConfig;

function createDefaultHost(array $overrides = []): ConfigRepository
{
    $config = new ConfigRepository;

    $config->setHost('default', [
        'host' => 'example.com',
        'user' => 'root',
        'port' => 22,
        'path' => '/',
        ...$overrides,
    ]);

    return $config;
}

function mockRemoteCommand($test, Closure $assertion): void
{
    $test->swap(RemoteCommand::class, $mock = m::mock(RemoteCommand::class));

    $mock
        ->shouldIgnoreMissing()
        ->shouldReceive('run')
        ->once()
        ->withArgs($assertion);
}

it('runs the remote command for an host', function () {
    createDefaultHost();

    mockRemoteCommand($this, fn ($input) => $input->getParameterOption('rawCommand') === 'test' &&
        $input->getParameterOption('--host') === 'default'
    );

    $this->artisan(GlobalRemoteCommand::class, [
        'rawCommand' => 'test',
        '--host' => 'default',
    ]);
});

it('does not pass a jump host when none is given or stored', function () {
    createDefaultHost();

    mockRemoteCommand($this, fn ($input) => ! $input->hasParameterOption('--jump'));

    $this->artisan(GlobalRemoteCommand::class, [
        'rawCommand' => 'test',
        '--host' => 'default',
    ]);
});

it('passes the jump host option to the remote command', function () {
    createDefaultHost();

    mockRemoteCommand($this, fn ($input) => $input->getParameterOption('--jump') === 'forge@bastion.com');

    $this->artisan(GlobalRemoteCommand::class, [
        'rawCommand' => 'test',
        '--host' => 'default',
        '--jump' => 'forge@bastion.com',
    ]);
});

it('passes the jump host stored for the host', function () {
    createDefaultHost(['jump' => 'forge@bastion.com']);

    mockRemoteCommand($this, fn ($input) => $input->getParameterOption('--jump') === 'forge@bastion.com');

    $this->artisan(GlobalRemoteCommand::class, [
        'rawCommand' => 'test',
        '--host' => 'default',
    ]);
});

it('prefers the jump host option over the one stored for the host', function () {
    createDefaultHost(['jump' => 'forge@stored.com']);

    mockRemoteCommand($this, fn ($input) => $input->getParameterOption('--jump') === 'forge@option.com');

    $this->artisan(GlobalRemoteCommand::class, [
        'rawCommand' => 'test',
        '--host' => 'default',
        '--jump' => 'forge@option.com',
    ]);
});

it('keeps the stored jump host out of the remote package config', function () {
    createDefaultHost(['jump' => 'forge@bastion.com']);

    mockRemoteCommand($this, fn ($input) => true);

    $this->artisan(GlobalRemoteCommand::class, [
        'rawCommand' => 'test',
        '--host' => 'default',
    ]);

    expect(config('remote.hosts.default'))->not->toHaveKey('jump');

    // A stray key would blow up here: `HostConfig` is built by spreading
    // the host as named arguments.
    expect(RemoteConfig::getHost('default')->host)->toBe('example.com');
});
