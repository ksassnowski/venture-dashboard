<?php

namespace Sassnowski\Venture\Dashboard\Queries;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;
use Sassnowski\Venture\Models\Workflow;
use Sassnowski\Venture\Models\WorkflowJob;

class FailedWorkflowsQuery
{
    private EloquentBuilder $query;

    public function __construct()
    {
        $this->query = Workflow::query()
            ->whereNull('finished_at')
            ->where('jobs_failed', '>', 0);
    }

    public function inTheLast(Carbon $date): self
    {
        $this->query = $this->query
            ->where('created_at', '>', $date);

        return $this;
    }

    /**
     * @return Collection<Workflow>
     */
    public function get(): Collection
    {
        return $this->query
            ->addSelect([
                'last_failed_at' => function (Builder $query) {
                    $workflowTable = (new Workflow())->getTable();
                    $jobsTable = (new WorkflowJob())->getTable();

                    $query
                        ->select("{$jobsTable}.failed_at")
                        ->from($jobsTable)
                        ->whereColumn("{$workflowTable}.id", "{$jobsTable}.workflow_id")
                        ->orderBy('failed_at', 'desc')
                        ->limit(1);
                },
            ])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function count(): int
    {
        return $this->query->count();
    }
}
