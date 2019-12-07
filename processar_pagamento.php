<?php 
include 'loader.php';

MercadoPago\SDK::setAccessToken($access_token);

$payment = new MercadoPago\Payment();

$payment->transaction_amount = $_POST['amount'];
$payment->description = $_POST['description'];
$payment->payment_method_id = $_POST['paymentMethodId'];

if(isset($_POST['token']))
	$payment->token = $_POST['token'];

if($_POST['paymentMethodId']=='bolbradesco') {
	// $payment->date_of_expiration = date('Y-m-dTH:i:s.000-04:00', strtotime('+4 days'));
	$payment->date_of_expiration = "2018-06-30T21:52:49.000-04:00";
	$payment->payer = [
		'email' => $_POST['email'],
		'first_name' => 'Test',
     	'last_name' => 'User',
		'identification' => array( 
			'type' => $_POST['docType'],
			'number' => $_POST['docNumber']
		),
		'address'=>  array(
			'zip_code' => '06233200',
			'street_name' => 'Av. das Nações Unidas',
			'street_number' => '3003',
			'neighborhood' => 'Bonfim',
			'city' => 'Osasco',
			'federal_unit' => 'SP'
		)
	];
}else{
	$payment->payer = ['email' => $_POST['email']];
	$payment->installments = $_POST['installments'];
}

$payment->save();

if($_POST['paymentMethodId']=='bolbradesco') {
	if(isset($payment->transaction_details->external_resource_url)) {
		$location = $payment->transaction_details->external_resource_url;
		
		header("Location: $location");
	}
}

echo $payment->status;
?>