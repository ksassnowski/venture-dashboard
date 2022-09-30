<?php

declare(strict_types=1);

namespace Sassnowski\Venture\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use RuntimeException;

class Dashboard
{
    /** @var callable|null */
    private static $authUsing = null;

    private static string $path = 'venture';

    /**
     * @param  callable(Request): bool  $callback
     */
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

    public static function setRoutePath(string $path): void
    {
        self::$path = $path;
    }

    public static function getRoutePath(): string
    {
        return self::$path;
    }

    public static function scriptVariables(): array
    {
        return [
            'path' => self::$path,
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
