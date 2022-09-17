<?php

namespace Sassnowski\Venture\Dashboard\Http\Resources;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\JsonResource;
use Sassnowski\Venture\Models\WorkflowJob;

/**
 * @property Collection<WorkflowJob> $resource
 */
class WorkflowStatusResource extends JsonResource
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
            ->map(function (WorkflowJob $job) {
                return [
                    'id' => $job->uuid,
                    'style' => match (true) {
                        $job->isProcessing() => 'processing',
                        $job->isFinished() => 'finished',
                        $job->hasFailed() => 'failed',
                        $job->isPending() => 'pending',
                        default => 'pending',
                    },
                ];
            })
            ->all();
    }
}
