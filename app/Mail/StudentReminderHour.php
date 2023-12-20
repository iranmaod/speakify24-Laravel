<?php

namespace App\Mail;

use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class StudentReminderHour extends Mailable
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
        if($data->student->comm_lang == 'deEmail')
        {
            return $this->subject('Sprachunterricht in 1 Stunde')->markdown('emails.student_reminder_hour_de',compact('data'));  
        }else
        {
            return $this->subject('Lesson in 1 hour')->markdown('emails.student_reminder_hour',compact('data'));
        }

        


    }
}
