<?php
require_once 'vendor/autoload.php';

MercadoPago\SDK::setAccessToken("TEST-7316851626238013-120305-28b36201c0800c8c76f089bbe5eeea1f-138014717");

$payment = new MercadoPago\Payment();
$payment->date_of_expiration = '2019-12-31T21:52:49.000-04:00';
$payment->transaction_amount = $_POST['amount'];
$payment->description = $_POST['description'];
$payment->payment_method_id = "bolbradesco";
$payment->payer = array(
    "email" => $_POST['email'],
    "first_name" => $_POST['first_name'],
    "last_name" => $_POST['last_name'],
    "identification" => array(
        "type" => $_POST['docType'],
        "number" => $_POST['docNumber']
    ),
    "address"=>  array(
        "zip_code" => $_POST['zip_code'],
        "street_name" => $_POST['street_name'],
        "street_number" => $_POST['street_number'],
        "neighborhood" => $_POST['neighborhood'],
        "city" => $_POST['city'],
        "federal_unit" => $_POST['federal_unit']
    )
);


$payment->save();
var_dump($payment);
?>