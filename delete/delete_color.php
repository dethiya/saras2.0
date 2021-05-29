<?php

include("../includes/header.php");
if (!$session->is_signed_in()) {redirect("login.php");}

if(empty($_GET['id'])) {
    redirect("../colors.php");
}

$color = Color::find($_GET['id']);

if($color) {
    $color->delete();
    $session->message('The Color has been deleted successfully!');
    redirect("../colors.php");
} else {
    redirect("../colors.php");
}
?>
