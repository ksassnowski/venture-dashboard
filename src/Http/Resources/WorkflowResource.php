<?php

namespace Sassnowski\Venture\Dashboard\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Juampi92\VentureMonitor\Render\MermaidGraph;
use Sassnowski\Venture\Models\Workflow;
use Sassnowski\Venture\Models\WorkflowJob;

/**
 * @mixin Workflow
 */
class WorkflowResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            ...$this->resource->toArray(),
            'definition' => WorkflowDefinitionResource::make($this->resource->jobs),
            'relations' => WorkflowRelationsResource::make($this->resource->jobs),
            'status' => WorkflowStatusResource::make($this->resource->jobs),
        ];
    }
}
