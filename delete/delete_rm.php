<?php

include("../includes/header.php");
if (!$session->is_signed_in()) {redirect("login.php");}

if(empty($_GET['id'])) {
    redirect("../rms.php");
}

$rm = Rm::find($_GET['id']);

if($rm) {
    $rm->delete();
    $session->message('The SRM has been deleted successfully!');
    redirect("../rms.php");
} else {
    redirect("../rms.php");
}

