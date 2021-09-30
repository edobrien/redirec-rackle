<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\SiteConstants;

class SelectedReportNotify extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $name;
    private $firm;
    private $position;
    private $email;
    private $contact_number;
    private $selected_report = [];

    public function __construct($requestData)
    {
        $this->name = $requestData->name;
        $this->firm = $requestData->firm;
        $this->position = $requestData->position;
        $this->email = $requestData->email;
        $this->contact_number = $requestData->contact_number;
        $this->selected_report = $requestData->selected_report;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.selected-report-notify')
                ->from('noreply@redirec.com')
                ->to(SiteConstants::ADMIN_EMAIL)
                ->subject("Recdirec: Report request Submission!")
                ->with([
                    "name" => $this->name,
                    "firm_name" => $this->firm,
                    "position" => $this->position,
                    "contact_number" => $this->contact_number,
                    "selected_report" => $this->selected_report,
                ]);
    }
}
