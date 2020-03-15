<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class TestMail extends Mailable
{
    public function build()
    {
        return $this->subject("Send 4 - Testmail")
            ->to('dersonsena@gmail.com', 'Kilderson Sena')
            ->markdown('mail.testMail');
    }
}
