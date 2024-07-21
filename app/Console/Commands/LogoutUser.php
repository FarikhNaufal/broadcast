<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LogoutUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:logout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Logout current user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = Auth::user();
        $userID = Auth::id();


        try {
            Auth::logout($user);
            DB::table('sessions')->truncate();
            $this->info('User logged out successfully.');
        } catch (\Throwable $th) {
            $this->error($th);
        }
    }


}
