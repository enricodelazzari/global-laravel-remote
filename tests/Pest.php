<?php

use App\Support\ConfigRepository;

uses(\Tests\Support\TestCase::class)
    ->beforeEach(fn () => hosts()->flush())
    ->in(__DIR__);

/**
 * The hosts under test. Always resolve them from the container: it hands out a
 * repository bound to a throwaway file, so the suite never touches the real
 * hosts of whoever is running it.
 */
function hosts(): ConfigRepository
{
    return app(ConfigRepository::class);
}

/**
 * @param  array<string, string|int>  $overrides
 */
function createDefaultHost(array $overrides = []): ConfigRepository
{
    return hosts()->setHost('default', [
        'host' => 'example.com',
        'user' => 'root',
        'port' => 22,
        'path' => '/',
        ...$overrides,
    ]);
}
