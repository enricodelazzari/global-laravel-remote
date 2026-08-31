<?php

namespace Tests\Support;

use Illuminate\Contracts\Console\Kernel;

trait CreatesApplication
{
    public function createApplication()
    {
        /*
         * Every test flushes the hosts, and flushing deletes the file, so a
         * suite pointed at the default location would wipe the hosts of
         * whoever is running it. This has to be in place before the container
         * is bootstrapped: commands are resolved while booting and hold on to
         * the repository they were handed.
         */
        $_ENV['REMOTE_CONFIG_PATH'] = $_SERVER['REMOTE_CONFIG_PATH'] = static::configPath();
        putenv('REMOTE_CONFIG_PATH='.static::configPath());

        $app = require __DIR__.'/../../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    public static function configPath(): string
    {
        return sys_get_temp_dir().'/remote-cli-tests-'.getmypid().'.json';
    }
}
