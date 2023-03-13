<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GitAutoPush extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'git:auto-push';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically push changes to Git repository';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // Add changes
        exec('git add .');

        // Commit changes
        exec('git commit -m "Automated commit"');

        // Push changes
        exec('git push');

        $this->info('Changes pushed to Git repository.');
    }
}
