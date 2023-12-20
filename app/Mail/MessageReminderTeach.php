<?php

namespace App\Mail;

use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MessageReminderTeach extends Mailable
{
    use Queueable, SerializesModels;
    public $enquiry;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   

        $data = $this->data;
        // echo "<pre>";
        // print_r($data);exit;
        if($data->msg_to->comm_lang == 'deEmail')
        {
            return $this->subject('Neue Nachricht für Sie')->markdown('emails.teacher_message_reminder_de',compact('data')); 
        }else
        {
            return $this->subject('New message for you')->markdown('emails.teacher_message_reminder',compact('data'));
        }

        


    }
}
