<?php

include("../includes/header.php");
if (!$session->is_signed_in()) {redirect("login.php");}

if(empty($_GET['id'])) {
    redirect("../stock-locations.php");
}

$stock_loc = StockLocation::find($_GET['id']);

if($stock_loc) {
    $stock_loc->delete();
    $session->message('The Stock location has been deleted successfully!');
    redirect("../stock-locations.php");
} else {
    redirect("../stock-locations.php");
}
?>
