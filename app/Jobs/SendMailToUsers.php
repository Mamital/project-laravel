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
            if($this->email->files->count() > 0)
            {
                $details = [
                    'title' => $this->email->subject,
                    'body' => $this->email->body,
                    'files' => $this->email->files,
                ];
            }else{
                $details = [
                    'title' => $this->email->subject,
                    'body' => $this->email->body,
                    'files' => ''
                ];
            }
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
