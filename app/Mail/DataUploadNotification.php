<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\DataUploadLog;
use App\SiteConstants;

class DataUploadNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $uploadLog;

    public function __construct($uploadLog)
    {
        $this->uploadLog = $uploadLog;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.data-upload-notify')
                ->subject('Recdirec - Data Upload')
                ->from('noreply@recdirec.com')
                ->to(SiteConstants::ADMIN_EMAIL)
                ->with([
                    'file' => $this->uploadLog->file_name
                ]);
    }
}
