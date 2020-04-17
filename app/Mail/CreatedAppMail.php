<?php

namespace App\Mail;

use App\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CreatedAppMail extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * The order instance.
     *
     * @var Application
     */
    protected $application;

    /**
     * Create a new message instance.
     *
     * @param Application $application
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.create')->with([
            'applicant'=>$this->application->user->name,
            'subject'=>$this->application->subject,
            'content'=>$this->application->content,
            'file'=>$this->application->file_url?'http://agilo/storage/'.$this->application->file_url:'#',
        ]);
    }
}
