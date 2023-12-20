<?php
use App\Models\User;
use App\Models\Appointment;
use App\Mail\StudentReminder;
use App\Mail\TeacherReminder;
use App\Mail\StudentReminderHour;
use App\Mail\TeacherReminderHour;
use Illuminate\Support\Facades\Mail;

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);
// echo 'test';exit;

// 26 hours reminder email
$start = date('Y-m-d H:i:s', strtotime('+26 hours'));

$appointments = Appointment::where('startdate', '<=', $start)->where('startdate', '>=', date("Y-m-d H:i:s", strtotime("+25 hours")))
							->where('status', 1)
							->get();


    if (count($appointments) > 0) {
        foreach ($appointments as $appointment) {
            $appointment->instructor = User::find($appointment->instructor_id);
            $appointment->student = User::find($appointment->user_id);
    
            $data = $appointment;
            $now = new DateTime($appointment->startdate);
            if ($appointment->instructor->timezone != '') {
                // date_default_timezone_set($appointment->instructor->timezone);
                $now->setTimezone(new DateTimeZone($appointment->instructor->timezone));
            } else {
                // date_default_timezone_set('Europe/Berlin');
                $now->setTimezone(new DateTimeZone('Europe/Berlin'));
            }
            $date = $now->format('d-m-Y');
            $time = $now->format('H:i');
    
            Mail::to('talhanadeem1721@gmail.com')->send(new TeacherReminder($data));
    
            if ($appointment->student->timezone != '') {
                // date_default_timezone_set($appointment->student->timezone);
                $now->setTimezone(new DateTimeZone($appointment->student->timezone));
            } else {
                // date_default_timezone_set('Europe/Berlin');
                $now->setTimezone(new DateTimeZone('Europe/Berlin'));
            }
            $date = $now->format('d-m-Y');
            $time = $now->format('H:i');
    
            Mail::to('talhanadeem1721@gmail.com')->send(new StudentReminder($data));
    
            $log_filename = "log";
            if (!file_exists($log_filename)) {
                mkdir($log_filename, 0777, true);
            }
            $log_file_data = $log_filename.'/log_' . date('d-M-Y') . '.log';
    
            file_put_contents($log_file_data, "Email send to Student " . $appointment->student->first_name . " " . $appointment->student->last_name . " (" .$appointment->student->id. ") and Instructor " . $appointment->instructor->first_name . " " . $appointment->instructor->last_name . " (" .$appointment->instructor->id. ")." . date('Y-m-d h:i:s') . "\n", FILE_APPEND);
        }
        
        echo 'Appointment Reminder sent successfully.';
    } else {
        $log_filename = "log";
        if (!file_exists($log_filename)) {
            mkdir($log_filename, 0777, true);
        }
        $log_file_data = $log_filename.'/log_' . date('d-M-Y') . '.log';
    
        file_put_contents($log_file_data, "No appointment found." . date('Y-m-d h:i:s') . "\n", FILE_APPEND);
        echo 'No Appointment found.';
    }  
    
    
////hourly email
    $start = date('Y-m-d H:i:s', strtotime('+1 hours'));

    $appointments = Appointment::where('startdate', '<=', $start)->where('startdate', '>=', date("Y-m-d H:i:s"))
                                ->where('status', 1)
                                ->get();
    
                                
        if (count($appointments) > 0) {
            foreach ($appointments as $appointment) {
                $appointment->instructor = User::find($appointment->instructor_id);
                $appointment->student = User::find($appointment->user_id);
        
                $data = $appointment;
                $now = new DateTime($appointment->startdate);
                if ($appointment->instructor->timezone != '') {
                    // date_default_timezone_set($appointment->instructor->timezone);
                    $now->setTimezone(new DateTimeZone($appointment->instructor->timezone));
                } else {
                    // date_default_timezone_set('Europe/Berlin');
                    $now->setTimezone(new DateTimeZone('Europe/Berlin'));
                }
                $date = $now->format('d-m-Y');
                $time = $now->format('H:i');
        
                Mail::to('talhanadeem1721@gmail.com')->send(new TeacherReminderHour($data));
        
                if ($appointment->student->timezone != '') {
                    // date_default_timezone_set($appointment->student->timezone);
                    $now->setTimezone(new DateTimeZone($appointment->student->timezone));
                } else {
                    // date_default_timezone_set('Europe/Berlin');
                    $now->setTimezone(new DateTimeZone('Europe/Berlin'));
                }
                $date = $now->format('d-m-Y');
                $time = $now->format('H:i');
        
                Mail::to('talhanadeem1721@gmail.com')->send(new StudentReminderHour($data));
        
                $log_filename = "log";
                if (!file_exists($log_filename)) {
                    mkdir($log_filename, 0777, true);
                }
                $log_file_data = $log_filename.'/log_' . date('d-M-Y') . '.log';
        
                file_put_contents($log_file_data, "Email send to Student " . $appointment->student->first_name . " " . $appointment->student->last_name . " (" .$appointment->student->id. ") and Instructor " . $appointment->instructor->first_name . " " . $appointment->instructor->last_name . " (" .$appointment->instructor->id. ")." . date('Y-m-d h:i:s') . "\n", FILE_APPEND);
            }
            
            echo 'Appointment Reminder sent successfully.'; exit;
        } else {
            $log_filename = "log";
            if (!file_exists($log_filename)) {
                mkdir($log_filename, 0777, true);
            }
            $log_file_data = $log_filename.'/log_' . date('d-M-Y') . '.log';
        
            file_put_contents($log_file_data, "No appointment found." . date('Y-m-d h:i:s') . "\n", FILE_APPEND);
            echo 'No Appointment found.'; exit;
        }        
    

?>