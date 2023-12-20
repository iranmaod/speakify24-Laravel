<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use Illuminate\Console\Command;

class AppointmentCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appointment:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        \Log::info("Cron is working fine!");
     
        /*
           Write your database logic we bellow:
           Item::create(['name'=>'hello new']);
        */

        // $start = date('Y-m-d H:i:s', strtotime('+24 hours'));
        // $end = date('Y-m-d H:i:s', strtotime('+25 hours'));

        // $appointments = Appointment::whereBetween('startdate', [$start, $end])
        //                             ->where('status', 1)->where('start', 1)->get();

        // if ($appointments) {
        //     foreach ($appointments as $appointment) {
        //         $appointment->instructor = User::find($appointment->instructor_id);
        //         $appointment->student = User::find($appointment->user_id);

        //         $data = $appointment;

        //         \Mail::send([], [
        //             'data' => $data
        //         ], function ($message) use($data){
        //             $MailBody = 'Hi '.$data->instructor->first_name.' '.$data->instructor->first_name.'!<br /><br />Your appointment is schedule with '.$data->student->first_name.' '.$data->student->first_name.' on '.date('d-m-Y h:i', strtotime($data->startdate)).'<br /><br />Thanks!';
        //             $message->setBody($MailBody, 'text/html');
        //             $message->subject('Appointment Reminder');
        //             $message->from('noreply@speakify24.com', 'Speakify24 Team');
        //             $message->to('talhanadeem1721@gmail.com');
        //         });

        //         \Mail::send([], [
        //             'data' => $data
        //         ], function ($message) use($data){
        //             $MailBody = 'Hi '.$data->student->first_name.' '.$data->student->first_name.'!<br /><br />Your appointment is schedule with '.$data->instructor->first_name.' '.$data->instructor->first_name.' on '.date('d-m-Y h:i', strtotime($data->startdate)).'<br /><br />Thanks!';
        //             $message->setBody($MailBody, 'text/html');
        //             $message->subject('Appointment Reminder');
        //             $message->from('noreply@speakify24.com', 'Speakify24 Team');
        //             $message->to('talhanadeem1721@gmail.com');
        //         });
        //     }
        // }

        $data = array();
        \Mail::send([], [
            'data' => $data
        ], function ($message) use($data){
            $MailBody = 'Hi!<br /><br />SUCCESS!!<br /><br />Thanks!';
            $message->setBody($MailBody, 'text/html');
            $message->subject('Test Registered');
            $message->from('noreply@speakify24.com', 'Nils Ahmed');
            $message->to('talhanadeem1721@gmail.com');
        });

        $this->info('Appointment:Cron Command Run Successfully!');
    }
}
