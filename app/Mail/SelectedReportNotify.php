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
    private $firm_name;
    private $position;
    private $email;
    private $contact_number;
    private $year_qualified;
    private $selected_report = [];
   
    public function __construct($requestData,$requestedReport)
    {
        $this->name = $requestData->name;
        $this->firm_name = $requestData->firm_name;
        $this->position = $requestData->position;
        $this->email = $requestData->email;
        $this->contact_number = $requestData->year_qualified;
        $this->selected_report = $requestedReport;

    }

    /**
     * Build the message.
     * console.log("")
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.selected-report-notify')
                ->from('noreply@therackle.com')
                ->to(SiteConstants::ADMIN_EMAIL)
                ->subject("Recdirec: report submission request!")
                ->with([
                    "name" => $this->name,
                    "firm_name" => $this->firm_name,
                    "position" => $this->position,
                    'email'=>$this->email,
                    "contact_number" => $this->contact_number,
                    "selected_report" => $this->selected_report,
                ]);
            
    }
}
