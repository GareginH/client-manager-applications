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
    protected $url;

    /**
     * Create a new message instance.
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
        return $this->markdown('emails.create')->with([
            'applicant'=>$this->application->user->name,
            'subject'=>$this->application->subject,
            'content'=>$this->application->content,
            'file'=>$this->application->file_url?'http://agilo/storage/'.$this->application->file_url:'#',
            'url'=>$this->url,
        ]);
    }
}
