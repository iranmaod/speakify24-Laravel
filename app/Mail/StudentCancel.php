<?php

namespace App\Mail;

use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class StudentCancel extends Mailable
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
        $user = \Auth::user();
        $data = $this->data;
        // echo "<pre>";
        // print_r($data);exit;
        if($data->student->comm_lang == 'deEmail')
        {
            return $this->subject('Lehrer musste Stunde canceln')->markdown('emails.student_cancel_de',compact('data','user'));  
        }else
        {
            return $this->subject('Teacher just canceled your lesson')->markdown('emails.student_cancel',compact('data','user'));
        }

        


    }
}
