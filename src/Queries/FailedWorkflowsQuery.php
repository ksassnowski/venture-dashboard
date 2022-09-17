<?php

namespace Sassnowski\Venture\Dashboard\Queries;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Sassnowski\Venture\Models\Workflow;

class FailedWorkflowsQuery
{
    private Builder $query;

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
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function count(): int
    {
        return $this->query->count();
    }
}
