<?php

namespace App\Commands;

use Illuminate\Support\Collection;

class HostsCommand extends Command
{
    public $signature = 'hosts';

    public $description = 'List the configured hosts';

    /**
     * The settings a host only carries when it needs them, and the column each
     * one gets. Showing them unconditionally would make the table too wide to
     * read for the hosts that use none of them.
     *
     * @var array<string, string>
     */
    protected const OPTIONAL_COLUMNS = [
        'phpPath' => 'PHP',
        'privateKeyPath' => 'SSH key',
        'jump' => 'Jump host',
    ];

    public function handle(): int
    {
        $hosts = collect($this->config->all());

        if ($hosts->isEmpty()) {
            $this->components->warn('There are no hosts created');

            return self::SUCCESS;
        }

        $optional = $this->optionalColumnsUsedBy($hosts);

        $this->table(
            ['Alias', 'Host', 'Port', 'User', 'Path', ...$optional->values()],
            $hosts->map(fn (array $host, string $alias) => [
                $alias,
                (string) ($host['host'] ?? ''),
                (string) ($host['port'] ?? ''),
                (string) ($host['user'] ?? ''),
                (string) ($host['path'] ?? ''),
                ...$optional->keys()->map(fn (string $key) => (string) ($host[$key] ?? '')),
            ])->values()->all()
        );

        $this->components->info("Stored in {$this->config->path()}");

        return self::SUCCESS;
    }

    /**
     * @param  Collection<string, array<string, string|int>>  $hosts
     * @return Collection<string, string>
     */
    protected function optionalColumnsUsedBy(Collection $hosts): Collection
    {
        return collect(self::OPTIONAL_COLUMNS)
            ->filter(fn (string $label, string $key) => $hosts->contains(
                fn (array $host) => ($host[$key] ?? '') !== ''
            ));
    }
}
