<?php

namespace Sassnowski\Venture\Dashboard\Queries;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Sassnowski\Venture\Models\Workflow;

class SuccessfulWorkflowsQuery
{
    private Builder $query;

    public function __construct()
    {
        $this->query = Workflow::query()->whereNotNull('finished_at');
    }

    public function inTheLast(Carbon $date): self
    {
        $this->query = $this->query
            ->where('finished_at', '>', $date);

        return $this;
    }

    /**
     * @return Collection<Workflow>
     */
    public function get(): Collection
    {
        return $this->query
            ->orderBy('finished_at', 'desc')
            ->get();
    }

    public function count(): int
    {
        return $this->query->count();
    }
}
