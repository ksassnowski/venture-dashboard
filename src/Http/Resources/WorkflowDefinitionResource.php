<?php

namespace Sassnowski\Venture\Dashboard\Http\Resources;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\JsonResource;
use Sassnowski\Venture\Dashboard\Support\JobNameResolver;
use Sassnowski\Venture\Models\WorkflowJob;

/**
 * @property Collection<WorkflowJob> $resource
 */
class WorkflowDefinitionResource extends JsonResource
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
            ->map(fn (WorkflowJob $job) => [
                'id' => $job->uuid,
                'name' => (new JobNameResolver())->resolve($job),
            ])
            ->all();
    }
}
