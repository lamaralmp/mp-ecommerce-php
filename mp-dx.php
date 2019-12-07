<?php

use MercadoPago\Payment;

require __DIR__  . '/vendor/autoload.php';

MercadoPago\SDK::setAccessToken("TEST-7316851626238013-120305-28b36201c0800c8c76f089bbe5eeea1f-138014717");

sendData($_POST);

function sendData($data){
    print_r($data);
    print_r (nl2br("\n------------------------------------\n"));

        $payment = new MercadoPago\Payment();
        $payment->transaction_amount = $data['amount'];
        $payment->token = $data['token'];
        $payment->description = $data['description'];
        $payment->installments = $data['installments'];
        $payment->payment_method_id = $data['paymentMethodId'];
        $payment->payer = array(
            "email" => $data['email']
        );

        $payment->save();

        var_dump($payment->status ? $payment->status : $payment->Error());
}