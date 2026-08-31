<?php

return [
    /*
     * This host will be used if none is specified
     * when executing the `remote` command.
     */
    'default_host' => 'default',

    /*
    * When set to true, A confirmation prompt will be shown before executing the `remote` command.
    */
    'needs_confirmation' => env('REMOTE_NEEDS_CONFIRMATION', false),

    /*
     * The file the configured hosts are stored in. When left empty,
     * `.laravel-remote.json` in the current user's home directory is used.
     */
    'config_path' => env('REMOTE_CONFIG_PATH'),
];
