<?php
$recived = $_POST;
switch ($_POST['payment_method']) {
    case "credit_card":
        require_once "detail_credit_card.php";
        break;
    case "bank_slip":
        require_once "detail_bank_slip.php";
        break;
    case "mercado_pago":
        require_once "detail_modal.php";
        break;
}