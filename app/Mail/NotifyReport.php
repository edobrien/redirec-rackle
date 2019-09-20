<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\SiteConstants;

class NotifyReport extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $user;
    private $report_name;

    public function __construct($user, $report_name)
    {
        $this->user = $user;
        $this->report_name = $report_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.report-notify')
                ->from($this->user->email)
                ->to(SiteConstants::ADMIN_EMAIL)
                ->subject("Recdirec: New Report Request!")
                ->with([
                    "user" => $this->user,
                    "report_name" => $this->report_name
                ]);
    }
}
