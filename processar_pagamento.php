<?php 
require_once 'vendor/autoload.php';

$public_key = 'TEST-93ab6e9a-a53f-4eff-a1b4-3c516e78c073';
$access_token = 'TEST-1565090771512161-120714-cb76e54140407d1690103d204c271bed-145814508';

MercadoPago\SDK::setAccessToken($access_token);

$payment = new MercadoPago\Payment();

$payment->transaction_amount = $_POST['amount'];
$payment->token = $_POST['token'];
$payment->description = $_POST['description'];
$payment->installments = $_POST['installments'];
$payment->payment_method_id = $_POST['paymentMethodId'];
$payment->payer = ['email' => $_POST['email']];

$payment->save();

echo $payment->status;
?>