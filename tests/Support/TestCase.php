<?php

namespace Tests\Support;

use App\Support\ConfigRepository;
use LaravelZero\Framework\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function tearDown(): void
    {
        $this->app?->make(ConfigRepository::class)->flush();

        parent::tearDown();
    }
}
