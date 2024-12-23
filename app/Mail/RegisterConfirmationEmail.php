<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class RegisterConfirmation extends Mailable
{
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('RegisterConfirmationEmail');
    }
}