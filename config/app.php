<?php

use App\Providers\AppServiceProvider;
use Composer\InstalledVersions;

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */

    'name' => 'Global Laravel Remote',

    /*
    |--------------------------------------------------------------------------
    | Application Version
    |--------------------------------------------------------------------------
    |
    | This value determines the "version" your application is currently running
    | in. Composer knows which version it installed, which is what a user of
    | the tool wants to see. Only fall back to asking git — a subprocess on
    | every single run — when it does not, as in a source checkout.
    |
    */

    'version' => InstalledVersions::isInstalled('spatie/global-laravel-remote')
        ? (InstalledVersions::getPrettyVersion('spatie/global-laravel-remote') ?? 'unreleased')
        : app('git.version'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. Anything other than "production" exposes Laravel Zero's
    | development commands (`app:build`, `make:*`, `test`), which have no
    | business being in an installed copy of this tool. Contributors who need
    | them can set APP_ENV=development in a local .env file.
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
    */

    'timezone' => 'UTC',

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => [
        AppServiceProvider::class,
    ],

];
