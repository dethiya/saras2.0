<?php

include("../includes/header.php");
if (!$session->is_signed_in()) {redirect("login.php");}

if(empty($_GET['id'])) {
    redirect("../channels.php");
}

$channel = Channel::find($_GET['id']);

if($channel) {
    $channel->delete();
    $session->message('The Channel has been deleted successfully!');
    redirect("../channels.php");
} else {
    redirect("../channels.php");
}
?>
