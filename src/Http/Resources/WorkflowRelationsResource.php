<?php

namespace Sassnowski\Venture\Dashboard\Http\Resources;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use Sassnowski\Venture\Models\WorkflowJob;

/**
 * @property Collection<WorkflowJob> $resource
 */
class WorkflowRelationsResource extends JsonResource
{
    /**
     * @param  Collection<WorkflowJob>  $jobs
     */
    public function __construct(Collection $jobs)
    {
        parent::__construct($jobs);
    }

    public function toArray($request)
    {
        return $this->resource
            ->flatMap(function (WorkflowJob $job) {
                return collect($job->edges)
                    ->map(fn ($edge) => ['start' => $job->uuid, 'end' => $edge])
                    ->all();
            })
            ->all();
    }
}
