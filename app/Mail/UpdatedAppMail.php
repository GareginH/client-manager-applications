<?php

namespace App\Mail;

use App\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UpdatedAppMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The order instance.
     *
     * @var Application
     */
    protected $application;
    protected $url;

    /**
     * Changes in application
     *
     * @param Application $application
     * @param $url
     */
    public function __construct(Application $application, $url)
    {
        $this->application = $application;
        $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.update')->with([
            'applicant'=>$this->application->user->name,
            'subject'=>$this->application->subject,
            'content'=> $this->application->content,
            'url'=>$this->url,
        ]);
    }
}
