<?php

namespace Sassnowski\Venture\Dashboard\Console;

use Illuminate\Console\Command;

class PublishCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'venture:dashboard:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish all of the Venture Dashboard resources';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->call('vendor:publish', [
            '--tag' => 'venture-dashboard-assets',
            '--force' => true,
        ]);
    }
}
