<?php

declare(strict_types=1);

namespace Sassnowski\Venture\Dashboard\Http\Controllers;

use Sassnowski\Venture\Dashboard\Http\Resources\WorkflowListItemResource;
use Sassnowski\Venture\Dashboard\Http\Resources\WorkflowResource;
use Sassnowski\Venture\Models\Workflow;

class WorkflowsController
{
    public function show(Workflow $workflow)
    {
        $workflow->loadMissing('jobs');

        return WorkflowResource::make($workflow);
    }

    public function running()
    {
        $workflows = Workflow::whereNull('finished_at')
            ->where('jobs_failed', 0)
            ->get();

        return WorkflowListItemResource::collection(
            $workflows
        );
    }

    public function failed()
    {
        $workflows = Workflow::query()
            ->whereNull('finished_at')
            ->where('jobs_failed', '>', 0)
            ->get();

        return WorkflowListItemResource::collection(
            $workflows
        );
    }

    public function finished()
    {
        $workflows = Workflow::whereNotNull('finished_at')->get();

        return WorkflowListItemResource::collection(
            $workflows
        );
    }
}
