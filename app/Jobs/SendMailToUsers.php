<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Http\Services\Message\MessageService;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use App\Http\Services\Message\Email\EmailService;

class SendMailToUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $users = User::whereNotNull('email')->get();
        foreach ($users as $user) {
            $details = [
                'title' => $this->email->subject,
                'body' => $this->email->body
            ];
            $emailService = new EmailService();
            $emailService->setDetails($details);
            $emailService->setTo($user->email);
            $emailService->setFrom('noreplay@example.com', 'فروشگاه آمازون');
            $emailService->setsubject('احراز هویت');

            $messageService = new MessageService($emailService);

            $messageService->send();
        }
    }
}
