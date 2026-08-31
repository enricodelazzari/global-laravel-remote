<?php

use App\Commands\FlushCommand;

it('removes all the hosts when called the command', function () {
    $config = createDefaultHost();

    expect($config->all())->toHaveCount(1);

    $this->artisan(FlushCommand::class)->assertOk();

    expect($config->all())->toHaveCount(0);
});
