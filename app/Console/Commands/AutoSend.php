<?php

namespace App\Console\Commands;

use App\Jobs\SendMailToUsers;
use App\Models\Notify\Email;
use Illuminate\Console\Command;

class AutoSend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:sendEmail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $emails = Email::all();
        foreach($emails as $email)
        {
            SendMailToUsers::dispatch($email);
        }
    }
}
