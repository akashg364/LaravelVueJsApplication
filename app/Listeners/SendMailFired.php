<?php

namespace App\Listeners;
use App\Events\SendMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;
class SendMailFired
{
    public function __construct()
    {
       
    }
    public function handle(SendMail $event)
    {
        $data = $event->emailData;
        Mail::send('emails.mailEvent', $data, function($message) use ($data) {
            $message->to($data['email']);
            $message->subject('New Post #'.$data['webName']);
        });
    }
}