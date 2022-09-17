<?php

namespace Sassnowski\Venture\Dashboard\Queries;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Sassnowski\Venture\Models\Workflow;

class PendingWorkflowsQuery
{
    private Builder $query;

    public function __construct()
    {
        $this->query = Workflow::whereNull('finished_at')
            ->where('jobs_failed', 0);
    }

    public function whereNonStarted(): self
    {
        $this->query = $this->query
            ->where('jobs_processed', 0);

        return $this;
    }

    /**
     * @return Collection<Workflow>
     */
    public function get(): Collection
    {
        return $this->query
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function count(): int
    {
        return $this->query->count();
    }
}
