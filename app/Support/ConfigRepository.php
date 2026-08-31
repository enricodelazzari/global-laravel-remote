<?php

namespace App\Support;

use Illuminate\Support\Arr;
use Spatie\Valuestore\Valuestore;

class ConfigRepository
{
    /**
     * Keys that only this application knows about. spatie/laravel-remote
     * spreads the stored host as named arguments on its `HostConfig`, so
     * these have to be stripped before handing the hosts over to it.
     *
     * @var array<int, string>
     */
    public const LOCAL_KEYS = ['jump'];

    protected Valuestore $valuestore;

    protected string $path;

    public function __construct(?string $path = null)
    {
        $this->path = $path ?: static::defaultPath();

        $this->valuestore = Valuestore::make($this->path);
    }

    /**
     * The file the hosts are stored in. Anything reading or writing hosts goes
     * through here, so pointing it somewhere else is enough to keep a process
     * away from the hosts of whoever is running it.
     */
    public function path(): string
    {
        return $this->path;
    }

    public static function defaultPath(): string
    {
        return static::findHomeDirectory().'/.laravel-remote.json';
    }

    /**
     * @return array<string, array<string, string|int>>
     */
    public function all(): array
    {
        return $this->valuestore->all();
    }

    /**
     * The hosts as spatie/laravel-remote expects them.
     *
     * @return array<string, array<string, string|int>>
     */
    public function remoteHosts(): array
    {
        return array_map(
            fn (array $host) => Arr::except($host, self::LOCAL_KEYS),
            $this->all()
        );
    }

    /**
     * @return array<string, string|int>|null
     */
    public function getHost(string $name): ?array
    {
        $host = $this->valuestore->get($name);

        return is_array($host) ? $host : null;
    }

    /**
     * @param  array<string, string|int>  $host
     */
    public function setHost(string $name, array $host = []): self
    {
        $this->valuestore->put([$name => $host]);

        return $this;
    }

    public function forgetHost(string $name): self
    {
        $this->valuestore->forget($name);

        return $this;
    }

    public function flush(): self
    {
        $this->valuestore->flush();

        return $this;
    }

    public function has(string $name): bool
    {
        return $this->valuestore->has($name);
    }

    public function __get(string $name): mixed
    {
        return $this->valuestore->get($name);
    }

    protected static function findHomeDirectory(): ?string
    {
        if (str_starts_with(PHP_OS, 'WIN')) {
            if (empty($_SERVER['HOMEDRIVE']) || empty($_SERVER['HOMEPATH'])) {
                return null;
            }

            $homeDirectory = $_SERVER['HOMEDRIVE'].$_SERVER['HOMEPATH'];

            return rtrim($homeDirectory, DIRECTORY_SEPARATOR);
        }

        if ($homeDirectory = getenv('HOME')) {
            return rtrim($homeDirectory, DIRECTORY_SEPARATOR);
        }

        return null;
    }
}
