<?php declare(strict_types=1);

namespace Sassnowski\Venture\Dashboard;

use Illuminate\Http\Request;

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
}
