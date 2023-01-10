<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\SiteConstants;

class FeedBackNotify extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $user;
    private $description;

    public function __construct($user, $description)
    {
        $this->user = $user;
        $this->description = $description;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.feedback-notify')
                ->from('noreply@redirec.com')
                ->to(SiteConstants::ADMIN_EMAIL)
                ->subject("Rackle: New Feedback Submission!")
                ->with([
                    "name" => $this->user->name,
                    "firm_name" => $this->user->firm_name,
                    "position" => $this->user->position,
                    "contact_number" => $this->user->contact_number,
                    "description" => $this->description,
                ]);
    }
}
