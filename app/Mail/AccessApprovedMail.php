<?php
namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccessApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $password;

    public function __construct(User $user, $password = null)
    {
        $this->user = $user;
        $this->password = $password;
    }

    public function build()
    {
        return $this->subject(__('messages.access_approved_subject'))
                    ->view('emails.access-approved');
    }
}