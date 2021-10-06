<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Imports\ImportUsers;

class ImportGuests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:guests';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import guest from CSV at storage/app/imports/laravel_users.csv';

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
     * @return int
     */
    public function handle()
    {
        $this->output->title('Starting import');
        (new ImportUsers)->withOutput($this->output)->import(storage_path('/app/imports/laravel_users.csv'));
        $this->output->success('Import successful');
        return 0;
    }
}
