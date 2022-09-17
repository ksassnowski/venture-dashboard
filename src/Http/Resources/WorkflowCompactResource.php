<?php

namespace Sassnowski\Venture\Dashboard\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Sassnowski\Venture\Models\Workflow;

/**
 * @mixin Workflow
 */
class WorkflowCompactResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'isFinished' => $this->isFinished(),
            'status' => WorkflowStatusResource::make($this->resource->jobs),
        ];
    }
}
