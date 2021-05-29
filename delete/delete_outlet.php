<?php

include("../includes/header.php");
if (!$session->is_signed_in()) {redirect("login.php");}

if(empty($_GET['id'])) {
    redirect("../outlets.php");
}

$outlet = Outlet::find($_GET['id']);

if($outlet) {
    $outlet->delete();
    $session->message('The Outlet has been deleted successfully!');
    redirect("../outlets.php");
} else {
    redirect("../outlets.php");
}

