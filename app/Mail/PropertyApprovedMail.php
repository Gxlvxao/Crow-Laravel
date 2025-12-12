<?php
namespace App\Mail;

use App\Models\Property;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PropertyApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $property;

    public function __construct(Property $property)
    {
        $this->property = $property;
    }

    public function build()
    {
        return $this->subject(__('messages.property_approved_subject'))
                    ->view('emails.property-approved');
    }
}