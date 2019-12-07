<?php  


ini_set('display_startup_errors', 1);
	ini_set('display_errors', 1);
	error_reporting(-1);

	require_once __DIR__ . '/vendor/autoload.php';

 MercadoPago\SDK::setAccessToken("TEST-061b3b20-e1da-4181-b66c-1dfb90985e17");

 $payment = new MercadoPago\Payment();
 $payment->date_of_expiration = "2020-06-30T21:52:49.000-04:00";
 $payment->transaction_amount = 100;
 $payment->description = "Title of what you are paying for";
 $payment->payment_method_id = "bolbradesco";
 $payment->payer = array(
     "email" => "test_user_19653727@testuser.com",
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

?>
