<?php

namespace Sassnowski\Venture\Dashboard\Http\Resources;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
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
                'name' => $this->extractJobName($job->job),
            ])
            ->all();
    }

    private function extractJobName(string $job): string
    {
        // TODO: who knows if this for all scenarios!
        [$length, $string] = Str::of($job)->after("WorkflowStepAdapter\x00job\";O:")->explode(':', 2);

        return Str::substr($string, 1, (int) $length);
    }
}
