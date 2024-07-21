<?php

namespace App\Console\Commands;

use App\Events\NoDataEvent;
use App\Events\SendDataEvent;
use App\Models\Client;
use Illuminate\Console\Command;

class SendData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:senddata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $client = Client::where('name', 'hehe')->first();
        NoDataEvent::dispatch($client, true);
        $this->info('Event dispatched successfully.');
    }
}
