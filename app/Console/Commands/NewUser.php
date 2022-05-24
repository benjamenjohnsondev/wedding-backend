<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class NewUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create
                            {party_name : Used as username}
                            {password}
                            {greeting_name : Used as a greeting (pretty) name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $user = new User([
            'expected_attending' => (int)1,
            'party_name' => $this->argument('party_name'),
            'greeting_name' => $this->argument('greeting_name'),
            'meal_choice' => json_encode([]),
            'password' => Hash::make($this->argument('password')),
        ]);

        $user->save();

        return 0;
    }
}
