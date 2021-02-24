<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MigrateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'canvas:migrate { --force : Force the operation to run when in production }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run Canvas migrations';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->callSilent('migrate', [
            // '--path' => 'app/database/migrations/canvas',
            '--path' => database_path('migrations/canvas/'),
            '--force' => $this->option('force') ?? true,
        ]);

        $this->info('Migration complete.');
    }
}
