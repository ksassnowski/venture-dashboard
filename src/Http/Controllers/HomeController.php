<?php

namespace Sassnowski\Venture\Dashboard\Http\Controllers;

use Illuminate\Support\Facades\App;
use Juampi92\VentureDashboard\VentureDashboard;
use Sassnowski\Venture\Dashboard\Dashboard;

class HomeController extends Controller
{
    /**
     * Single page application catch-all route.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('venture-dashboard::layout', [
            'assetsAreCurrent' => Dashboard::assetsAreCurrent(),
            'ventureDashboardScriptVariables' => Dashboard::scriptVariables(),
            'isDownForMaintenance' => App::isDownForMaintenance(),
        ]);
    }
}
