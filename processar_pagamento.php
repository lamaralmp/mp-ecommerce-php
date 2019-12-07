<?php  

    require_once 'vendor/autoload.php';

    MercadoPago\SDK::setAccessToken("TEST-6238996572525156-120714-adc1fe90e9fe043fa4b0e3f018f42fe8-497947094");
    //...
    $payment = new MercadoPago\Payment();
    $payment->transaction_amount = (int)$_POST['amount'];
    $payment->token = $_POST['token'];
    $payment->description = "Lightweight Silk Watch";
    $payment->installments = (int)$_POST['installments'];
    $payment->payment_method_id = $_POST['paymentMethodId'];
    $payment->issuer_id = $_POST['issuer_id'];
    $payment->notification_url = "https://762a5e7c.ngrok.io/mp-ecommerce-php/notification.php";
    $payment->payer = array(
    "email" => $_POST['email']
    );
    // Save and posting the payment
    $payment->save();
    //...
    // Print the payment status
    echo $payment->status;
    //...

    echo '<pre>';

    print_r($payment);