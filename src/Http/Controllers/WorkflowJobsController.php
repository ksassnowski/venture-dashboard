<?php

declare(strict_types=1);

namespace Sassnowski\Venture\Dashboard\Http\Controllers;

use Sassnowski\Venture\Dashboard\Http\Resources\WorkflowCompactResource;
use Sassnowski\Venture\Models\Workflow;

class WorkflowJobsController
{
    public function index(Workflow $workflow)
    {
        $workflow->loadMissing('jobs');

        return WorkflowCompactResource::make($workflow);
    }
}
