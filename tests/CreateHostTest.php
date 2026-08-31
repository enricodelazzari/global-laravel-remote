<?php

use App\Commands\GlobalRemoteCommand;
use Mockery as m;
use Spatie\Remote\Commands\RemoteCommand;
use Spatie\Remote\Config\RemoteConfig;

beforeEach(function () {
    $mock = $this->swap(RemoteCommand::class, m::mock(RemoteCommand::class));

    $mock->shouldIgnoreMissing()->shouldReceive('run');
});

/**
 * The prompts every host goes through, up to the point where the optional
 * settings are offered.
 */
function answerTheRequiredPrompts($command)
{
    return $command
        ->expectsConfirmation('Would you like to create one?', 'yes')
        ->expectsQuestion('Provide the alias for your host', 'staging')
        ->expectsQuestion('Provide the host', 'staging')
        ->expectsQuestion('Username', 'forge')
        ->expectsQuestion('Port', '22')
        ->expectsQuestion('Path to the laravel codebase', '/home/forge/staging');
}

it('creates a host from the required settings alone', function () {
    answerTheRequiredPrompts($this->artisan(GlobalRemoteCommand::class, ['rawCommand' => 'migrate']))
        ->expectsConfirmation('Do you need a custom PHP binary, SSH key or jump host?', 'no')
        ->run();

    expect(hosts()->getHost('staging'))->toBe([
        'host' => 'staging',
        'port' => 22,
        'user' => 'forge',
        'path' => '/home/forge/staging',
    ]);
});

it('creates a host with a custom php binary, ssh key and jump host', function () {
    answerTheRequiredPrompts($this->artisan(GlobalRemoteCommand::class, ['rawCommand' => 'migrate']))
        ->expectsConfirmation('Do you need a custom PHP binary, SSH key or jump host?', 'yes')
        ->expectsQuestion('Path to the PHP binary on the server', '/usr/bin/php8.3')
        ->expectsQuestion('Path to the SSH private key', '/home/forge/.ssh/id_ed25519')
        ->expectsQuestion('Jump host', 'forge@bastion.com')
        ->run();

    expect(hosts()->getHost('staging'))
        ->phpPath->toBe('/usr/bin/php8.3')
        ->privateKeyPath->toBe('/home/forge/.ssh/id_ed25519')
        ->jump->toBe('forge@bastion.com');

    // Both of these are `HostConfig` arguments, so unlike the jump host they
    // have to survive the trip into spatie/laravel-remote.
    expect(RemoteConfig::getHost('staging'))
        ->phpPath->toBe('/usr/bin/php8.3')
        ->privateKeyPath->toBe('/home/forge/.ssh/id_ed25519');
});

it('leaves the optional settings out when they are skipped', function () {
    answerTheRequiredPrompts($this->artisan(GlobalRemoteCommand::class, ['rawCommand' => 'migrate']))
        ->expectsConfirmation('Do you need a custom PHP binary, SSH key or jump host?', 'yes')
        ->expectsQuestion('Path to the PHP binary on the server', 'php')
        ->expectsQuestion('Path to the SSH private key', '')
        ->expectsQuestion('Jump host', '')
        ->run();

    expect(hosts()->getHost('staging'))
        ->not->toHaveKey('privateKeyPath')
        ->not->toHaveKey('jump');
});
