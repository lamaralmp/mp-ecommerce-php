<?php  

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// exit;

    require_once 'vendor/autoload.php';

    MercadoPago\SDK::setAccessToken("TEST-6238996572525156-120714-adc1fe90e9fe043fa4b0e3f018f42fe8-497947094");
    //...
    $payment = new MercadoPago\Payment();



 $payment->date_of_expiration = "2018-06-30T21:52:49.000-04:00";
 $payment->transaction_amount = (int)$_POST['amount'];
 $payment->description = "Title of what you are paying for";
 $payment->payment_method_id = "bolbradesco";
 $payment->notification_url = "https://762a5e7c.ngrok.io/mp-ecommerce-php/notification.php";
 $payment->payer = array(
     "email" => $_POST['email'],
     "first_name" => "Test",
     "last_name" => "User",
     "identification" => array( 
         "type" => "CPF",
         "number" => "19119119100"
      ),
     "address"=>  array(
         "zip_code" => "06233200",
         "street_name" => "Av. das Nações Unidas",
         "street_number" => "3003",
         "neighborhood" => "Bonfim",
         "city" => "Osasco",
         "federal_unit" => "SP"
      )
   );

 $payment->save();


    // $payment->transaction_amount = (int)$_POST['amount'];
    // $payment->token = $_POST['token'];
    // $payment->description = "Lightweight Silk Watch";
    // $payment->installments = (int)$_POST['installments'];
    // $payment->payment_method_id = "bolbradesco";
    // $payment->issuer_id = $_POST['issuer_id'];
    // $payment->notification_url = "https://762a5e7c.ngrok.io/mp-ecommerce-php/notification.php";
    // $payment->payer = array(
    // "email" => $_POST['email']
    // );
    // // Save and posting the payment
    // $payment->save();
    //...
    // Print the payment status
    echo $payment->status;
    //...

    echo '<pre>';

    print_r($payment);