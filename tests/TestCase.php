<?php declare(strict_types=1);

namespace Sassnowski\Venture\Dashboard\Tests;

use Sassnowski\Venture\Dashboard\DashboardServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [DashboardServiceProvider::class];
    }
}
