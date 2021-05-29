<?php

include("../includes/header.php");
if (!$session->is_signed_in()) {redirect("login.php");}

if(empty($_GET['id'])) {
    redirect("../variants.php");
}

$variant = Variant::find($_GET['id']);

if($variant) {
    $variant->delete();
    $session->message("The Variant {$variant->variant_name} has been deleted successfully!");
    redirect("../variants.php");
} else {
    redirect("../variants.php");
}
?>
