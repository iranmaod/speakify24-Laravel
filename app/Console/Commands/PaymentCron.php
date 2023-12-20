<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Appointment;
use App\Models\Transaction;
use PayPal\Api\Plan;
use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Common\PayPalModel;
use PayPal\Api\Agreement;
use PayPal\Api\AgreementStateDescriptor;
use Illuminate\Support\Facades\Mail;
class PaymentCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:cron';

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
        $transactions = Transaction::where('type', 'plan')
							->where('status', 'completed')
							->get();
    // $transactions = Transaction::where('type', 'plan')->where('created_at', '<=', date("Y-m-d H:i:s", strtotime("-1 month")))
    // 							->where('status', 'completed')
    // 							->get();
    $log_filename = "log";
    if (!file_exists($log_filename)) {
        mkdir($log_filename, 0777, true);
    }
    $log_file_data = $log_filename.'/log_payment' . date('d-M-Y') . '.log';

    if (count($transactions) > 0) {
	$apiContext = new \PayPal\Rest\ApiContext(
		new \PayPal\Auth\OAuthTokenCredential(
			\Config::get('paypal.client_id'),
			\Config::get('paypal.secret')
		)
	);

	$apiContext->setConfig(array(
		'mode' => 'sandbox',
	));

	foreach ($transactions as $transaction) {
		$orderDetails = json_decode($transaction->order_details);
	
		try {
			$plan = Plan::get($orderDetails->id, $apiContext);

			$agreement = Agreement::get($orderDetails->agreement_id, $apiContext);

			// $bill_date = date('Y-m-d', strtotime($agreement->agreement_details->last_payment_date));
			$bill_date = date('Y-m-d', strtotime($agreement->agreement_details->next_billing_date));
	// 		echo '<pre>';
	// print_r($agreement);exit;
// echo $bill_date; echo '<br>';
// echo date('Y-m-d', strtotime('-2 days')); echo '<br>';
			if ($bill_date == date('Y-m-d')) {
				$newtransaction = new Transaction;
				$newtransaction->user_id = $transaction->user_id;
				$newtransaction->course_id = $transaction->course_id;
				$newtransaction->amount = $transaction->amount;
				$newtransaction->status = 'completed';
				$newtransaction->type = 'plan';
				$newtransaction->type_id = $transaction->type_id;
				$newtransaction->payment_method = 'express_checkout';
				$newtransaction->order_details = $transaction->order_details;
				$newtransaction->appointment_id = 0;
				$newtransaction->save();

				$transaction->status = 'cancelled';
				$transaction->save();

				file_put_contents($log_file_data, 'New transaction ('.$newtransaction->id.') added.' . date('Y-m-d h:i:s') . "\n", FILE_APPEND);
			}
		} catch (Exception $ex) {
			file_put_contents($log_file_data, $ex->getMessage() . date('Y-m-d h:i:s') . "\n", FILE_APPEND);
		}
	}
	exit;
} else {
	file_put_contents($log_file_data, "No data found." . date('Y-m-d h:i:s') . "\n", FILE_APPEND);
}
  
    }
}
