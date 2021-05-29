<?php

include("../includes/header.php");
if (!$session->is_signed_in()) {redirect("login.php");}

if(empty($_GET['id'])) {
    redirect("../banks.php");
}

$bank = Bank::find($_GET['id']);

if($bank) {
    $bank->delete();
    $session->message('The Bank has been deleted successfully!');
    redirect("../banks.php");
} else {
    redirect("../banks.php");
}
?>
