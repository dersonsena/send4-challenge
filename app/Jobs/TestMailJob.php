<?php

namespace App\Jobs;

use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;

class TestMailJob extends Job
{
    public function handle()
    {
        Mail::send(new TestMail());
    }
}
