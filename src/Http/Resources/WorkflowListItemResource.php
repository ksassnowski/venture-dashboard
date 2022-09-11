<?php

namespace Sassnowski\Venture\Dashboard\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Sassnowski\Venture\Models\Workflow;

/**
 * @mixin Workflow
 *
 * @property Workflow $resource
 */
class WorkflowListItemResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'jobs' => [
                'total' => $this->job_count,
                'processed' => $this->jobs_processed,
                'failed' => $this->jobs_failed,
            ],
            'completion' => floor((($this->jobs_processed + $this->jobs_failed) / $this->job_count) * 100),
            'created_at' => $this->created_at,
            'state' => match (true) {
                $this->isFinished() => 'finished',
                default => 'not-finished',
            },
        ];
    }
}
