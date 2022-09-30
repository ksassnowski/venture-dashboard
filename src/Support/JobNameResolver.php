<?php

namespace Sassnowski\Venture\Dashboard\Support;

use Illuminate\Support\Str;
use Sassnowski\Venture\Models\WorkflowJob;
use Sassnowski\Venture\WorkflowStepAdapter;

class JobNameResolver
{
    public function __construct()
    {
    }

    public function resolve(WorkflowJob $job): string
    {
        if ($job->name !== WorkflowStepAdapter::class) {
            // Job has a custom name.
            return $job->name;
        }

        return $this->extractFromJobCommand($job->job) ?: $job->name;
    }

    private function extractFromJobCommand(string $job): ?string
    {
        [$length, $string] = Str::of($job)
            ->after(WorkflowStepAdapter::class . "\x00job\";O:")->explode(':', 2) ?? [null, null];

        if (!$length) {
            return null;
        }

        return Str::substr($string, 1, (int) $length);
    }
}
