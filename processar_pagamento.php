<?php  
	ini_set('display_startup_errors', 1);
	ini_set('display_errors', 1);
	error_reporting(-1);



require_once __DIR__ . '/../vendor/autoload.php';
	$token = $_POST["token"];
	$paymentMethodId = $_POST["paymentMethodId"];
	$description = $_POST["description"];
	$installments = $_POST["installments"];



	MercadoPago\SDK::setAccessToken("APP_USR-4233004109173917-022523-d9cc5cdde631ccf7ad9cffce4b29d71d__LA_LB__-31639991");
	//...
	$payment = new MercadoPago\Payment();
	$payment->transaction_amount = 181;
	$payment->token = $token;
	$payment->description = $description;
	$payment->installments = $installments;
	$payment->payment_method_id = $paymentMethodId;
	$payment->payer = array(
		"email" => "itamar.ilourenco@gmail.com"
	);
	// Save and posting the payment
	$payment->save();
	//...
	// Print the payment status
	echo $payment->status;
	//...
?>
