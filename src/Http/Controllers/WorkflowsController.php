<?php declare(strict_types=1);

namespace Sassnowski\Venture\Dashboard\Http\Controllers;

use Illuminate\Contracts\View\View;
use Sassnowski\Venture\Models\Workflow;
use Sassnowski\Venture\Models\WorkflowJob;

class WorkflowsController extends Controller
{
    public function show(Workflow $workflow): View
    {
        return view('venture-dashboard::workflows.show', [
            'workflow' => $workflow,
            'graph' => $workflow->asAdjacencyList(),
            'table' => [
                'headers' => [
                    ['text' => 'Name', 'align' => 'left'],
                    ['text' => 'Finished at', 'align' => 'right'],
                    ['text' => 'Failed at', 'align' => 'right'],
                ],
                'items' => $workflow->jobs
                    ->map(fn (WorkflowJob $job) => [
                        $job->name,
                        optional($job->finished_at)->format('Y-m-d H:i'),
                        optional($job->failed_at)->format('Y-m-d H:i'),
                    ])
            ],
        ]);
    }

    public function running(): View
    {
        return view('venture-dashboard::workflows.index', [
            'workflows' => Workflow::whereNull('finished_at')
                ->where('jobs_failed', 0)
                ->get(),
        ]);
    }

    public function failed(): View
    {
        return view('venture-dashboard::workflows.failed', [
            'workflows' => Workflow::with('jobs')
                ->whereNull('finished_at')
                ->where('jobs_failed', '>', 0)
                ->get(),
        ]);
    }

    public function finished(): View
    {
        return view('venture-dashboard::workflows.finished', [
            'workflows' => Workflow::whereNotNull('finished_at')->get(),
        ]);
    }
}
