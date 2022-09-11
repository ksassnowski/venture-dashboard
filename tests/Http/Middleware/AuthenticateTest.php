<?php

declare(strict_types=1);

namespace Sassnowski\Venture\Dashboard\Tests\Http\Middleware;

use Generator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Sassnowski\Venture\Dashboard\Dashboard;
use Sassnowski\Venture\Dashboard\Http\Middleware\Authenticate;
use Sassnowski\Venture\Dashboard\Tests\TestCase;

class AuthenticateTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Route::get('/auth-test', function () {
            return 'ok';
        })->middleware(Authenticate::class);
    }

    /**
     * @test
     * @dataProvider callbackProvider
     */
    public function itCallsTheProvidedCallbackIfNotInLocalEnvironment(callable $callback, int $expectedStatus): void
    {
        Dashboard::auth($callback);

        $this->get('/auth-test')->assertStatus($expectedStatus);
    }

    public function callbackProvider(): Generator
    {
        yield from [
            'should pass' => [fn (Request $request) => true, 200],
            'should fail' => [fn (Request $request) => false, 403],
        ];
    }
}
