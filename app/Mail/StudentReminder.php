<?php

namespace App\Mail;

use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class StudentReminder extends Mailable
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
            return $this->subject('Sprachunterricht in 26 Stunden')->markdown('emails.student_reminder_de',compact('data'));  
        }else
        {
            return $this->subject('Lesson in 26 hours')->markdown('emails.student_reminder',compact('data'));
        }

        


    }
}
