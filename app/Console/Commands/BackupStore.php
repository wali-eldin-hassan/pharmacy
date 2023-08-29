<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BackupStore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:run --only-files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new backup for files only';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
    }
}
