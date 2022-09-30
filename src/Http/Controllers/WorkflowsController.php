<?php

declare(strict_types=1);

namespace Sassnowski\Venture\Dashboard\Http\Controllers;

use Sassnowski\Venture\Dashboard\Http\Resources\WorkflowListItemResource;
use Sassnowski\Venture\Dashboard\Http\Resources\WorkflowResource;
use Sassnowski\Venture\Dashboard\Queries\FailedWorkflowsQuery;
use Sassnowski\Venture\Dashboard\Queries\PendingWorkflowsQuery;
use Sassnowski\Venture\Dashboard\Queries\SuccessfulWorkflowsQuery;
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
        $workflows = (new PendingWorkflowsQuery())->get();

        return WorkflowListItemResource::collection(
            $workflows
        );
    }

    public function failed()
    {
        $workflows = (new FailedWorkflowsQuery())->get();

        return WorkflowListItemResource::collection(
            $workflows
        );
    }

    public function finished()
    {
        $workflows = (new SuccessfulWorkflowsQuery())->get();

        return WorkflowListItemResource::collection(
            $workflows
        );
    }
}
