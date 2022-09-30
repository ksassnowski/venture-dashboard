<?php

namespace Sassnowski\Venture\Dashboard\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Sassnowski\Venture\Dashboard\Support\JobNameResolver;
use Sassnowski\Venture\Models\WorkflowJob;

/**
 * @mixin WorkflowJob
 */
class JobResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => (new JobNameResolver())->resolve($this->resource),
            'finishedAt' => $this->finished_at,
            'failedAt' => $this->failed_at,
            'exception' => $this->exception,
        ];
    }
}
