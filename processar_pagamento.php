<?php 
include 'loader.php';

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