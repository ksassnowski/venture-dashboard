<?php

declare(strict_types=1);

namespace Sassnowski\Venture\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use RuntimeException;

class Dashboard
{
    public static $authUsing = null;

    public static function auth(callable $callback): void
    {
        static::$authUsing = $callback;
    }

    public static function check(Request $request): bool
    {
        return (static::$authUsing ?: function () {
            return app()->environment('local');
        })($request);
    }

    public static function scriptVariables(): array
    {
        return [
            'path' => 'venture',
        ];
    }

    /**
     * Determine if VentureDashboard's published assets are up-to-date.
     *
     * @return bool
     *
     * @throws \RuntimeException
     */
    public static function assetsAreCurrent(): bool
    {
        $publishedPath = public_path('vendor/venture-dashboard/mix-manifest.json');

        if (! File::exists($publishedPath)) {
            throw new RuntimeException('Venture Dashboard assets are not published. Please run: php artisan venture:dashboard:publish');
        }

        return File::get($publishedPath) === File::get(__DIR__.'/../public/mix-manifest.json');
    }
}
