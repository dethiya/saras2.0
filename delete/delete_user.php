<?php

include("../includes/header.php");
if (!$session->is_signed_in()) {redirect("login.php");}

if(empty($_GET['id'])) {
    redirect("../users.php");
}

$user = User::find($_GET['id']);

if($user) {
    $user->delete();
    $session->message("The Employee has been deleted successfully!");
    redirect("../users.php");
} else {
    redirect("../users.php");
}
?>
