<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnviarMensagem extends Mailable
{
    use Queueable, SerializesModels;

    protected $contactform_name;
    protected $contactform_email;
    protected $contactform_phone;
    protected $contactform_subject;
    protected $contactform_service;
    protected $contactform_body;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(
            $contactform_name,
            $contactform_email,
            $contactform_phone,
            $contactform_subject,
            $contactform_service,
            $contactform_body
        )
    {
        $this->contactform_name = $contactform_name;
        $this->contactform_email = $contactform_email;
        $this->contactform_phone = $contactform_phone;
        $this->contactform_subject = $contactform_subject;
        $this->contactform_service = $contactform_service;
        $this->contactform_body = $contactform_body;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('site@mazda-autozuid.co.ao')
                    ->subject('New Customer Equiry')
                    ->view('contact')
                    ->with([
                        'name' => $this->contactform_name,
                        'email' => $this->contactform_email,
                        'phone' => $this->contactform_phone,
                        'subject' => $this->contactform_subject,
                        'service' => $this->contactform_service,
                        'body' => $this->contactform_body,
                    ]);
    }
}
