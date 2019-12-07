<?php  

	$token = $_POST["token"];
	$paymentMethodId = $_POST["paymentMethodId"];
	$description = $_POST["description"];
	$installments = $_POST["installments"];

    require_once 'vendor/autoload.php';

    MercadoPago\SDK::setAccessToken("ENV_ACCESS_TOKEN");
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