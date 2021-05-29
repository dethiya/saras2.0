<?php

include("../includes/header.php");
if (!$session->is_signed_in()) {redirect("login.php");}

if(empty($_GET['id'])) {
    redirect("../srms.php");
}

$srm = Srm::find($_GET['id']);

if($srm) {
    $srm->delete();
    $session->message('The SRM has been deleted successfully!');
    redirect("../srms.php");
} else {
    redirect("../srms.php");
}

