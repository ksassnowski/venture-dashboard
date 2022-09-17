<?php

namespace Sassnowski\Venture\Dashboard\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Sassnowski\Venture\Dashboard\Queries\FailedWorkflowsQuery;
use Sassnowski\Venture\Dashboard\Queries\PendingWorkflowsQuery;
use Sassnowski\Venture\Dashboard\Queries\SuccessfulWorkflowsQuery;
use Sassnowski\Venture\Models\Workflow;

class StatsIndexController
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'period' => ['required', 'in:hour,day'],
        ]);

        $date = match ($request->period) {
            'hour' => Carbon::now()->subHour(),
            'day' => Carbon::now()->subDay(),
            default => Carbon::now()->subHour(),
        };

        // $date

        return response()->json([
            'totalPending' => (new PendingWorkflowsQuery())->count(),
            'totalNonStarted' => (new PendingWorkflowsQuery())->whereNonStarted()->count(),
            'failed' => (new FailedWorkflowsQuery())->inTheLast($date)->count(),
            'successful' => (new SuccessfulWorkflowsQuery())->inTheLast($date)->count(),
            'created' => Workflow::where('created_at', '>', $date)->count(),
        ]);
    }
}
