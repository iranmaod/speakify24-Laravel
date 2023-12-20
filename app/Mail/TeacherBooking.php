<?php

namespace App\Mail;

use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TeacherBooking extends Mailable
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
        if($data->instructor->comm_lang == 'deEmail')
        {
            return $this->subject('Ein Schüler hat gerade eine Unterrichtsstunde bei dir gebucht')->markdown('emails.teacher_booking_de',compact('data','user')); 
        }else
        {
            return $this->subject('Student just booked a lesson with you')->markdown('emails.teacher_booking',compact('data','user'));
        }


    }
}
