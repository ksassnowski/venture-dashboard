<?php declare(strict_types=1);

namespace Sassnowski\Venture\Dashboard\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Sassnowski\Venture\Dashboard\Http\Middleware\Authenticate;

class Controller extends BaseController
{
    public function __construct()
    {
        $this->middleware(Authenticate::class);
    }
}
