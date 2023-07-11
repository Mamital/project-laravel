<?php

namespace App\Http\Services\Message\Email;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;

class MailViewProvider extends Mailable
{
    use Queueable, SerializesModels;

    public $details;

    public function __construct($details, $subject, $from)
    {
        $this->details = $details;
        $this->subject = $subject;
        $this->from = $from;
    }

    public function build()
    {
        return $this->subject($this->subject)->view('emails.send-otp');
    }

    public function attachments(): array
    {
        $files = [];
        // dd($this->details['files']);
        if ($this->details['files'] != null) {
            foreach ($this->details['files'] as $file) {
                    array_push($files, Attachment::fromPath($file->file_path));
            }
        }
        return $files;
    }
}
