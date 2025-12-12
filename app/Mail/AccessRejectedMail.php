<?php
namespace App\Mail;

use App\Models\AccessRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccessRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $request;

    public function __construct(AccessRequest $request)
    {
        $this->request = $request;
    }

    public function build()
    {
        return $this->subject(__('messages.access_rejected_subject'))
                    ->view('emails.access-rejected');
    }
}