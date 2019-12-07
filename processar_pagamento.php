<?php 
	require_once __DIR__ . '/vendor/autoload.php';

	$token = $_POST["token"];
	$paymentMethodId = $_POST["paymentMethodId"];
	$description = $_POST["description"];
	$installments = $_POST["installments"];


	MercadoPago\SDK::setAccessToken("TEST-4233004109173917-022523-71f5f5e3ff4e4165b88bbece6a599bdf__LB_LD__-31639991");


	//...
	$payment = new MercadoPago\Payment();
	$payment->transaction_amount = 1000;
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
	// Print the payment sitatus
	echo $payment->status;

echo "<br><br><br>";

	echo "Error\n";
print_r($payment->error);

echo "Resposta completa\n";

	print_r($payment);

?>
