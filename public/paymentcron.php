<?php
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

require __DIR__.'/../vendor/autoload.php';




$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);


mail("talhauos1@gmail.com","Payment File",'payment file is running');


$transactions = Transaction::where('type', 'plan')->whereDate('created_at', '<=', date("Y-m-d", strtotime("-1 month")))
							->where('status', 'completed')
							->get();

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
		'mode' => 'live',
	));

	

	foreach ($transactions as $transaction) {
		$orderDetails = json_decode($transaction->order_details);

		try {
			$plan = Plan::get($orderDetails->id, $apiContext);

			$agreement = Agreement::get($orderDetails->agreement_id, $apiContext);
		
			$bill_date = date('Y-m-d', strtotime($agreement->agreement_details->last_payment_date));
			// $bill_date = date('Y-m-d', strtotime($agreement->agreement_details->next_billing_date));
// echo '<pre>';
// print_r($agreement);
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
				$newtransaction_id = $newtransaction->id;

				$transaction->status = 'cancelled';
				$transaction->save();
				file_put_contents($log_file_data, 'New transaction ('.$newtransaction_id.') added.' . date('Y-m-d h:i:s') . "\n", FILE_APPEND);
			}
		} catch (Exception $ex) {
			file_put_contents($log_file_data, $ex->getMessage() . date('Y-m-d h:i:s') . "\n", FILE_APPEND);
		}
	}
	exit;
} else {
	file_put_contents($log_file_data, "No data found." . date('Y-m-d h:i:s') . "\n", FILE_APPEND);
}

?>