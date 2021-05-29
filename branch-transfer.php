<?php

include("includes/header.php");
if (!$session->is_signed_in()) {redirect("login.php");}

if(empty($_GET['id'])) {
    redirect("view-requests.php");
}
$get_vehicle_id=$_GET['id'];
$issue = Indent::find($get_vehicle_id);
$allotment=Stock::find($indent->vehicle_id);
if($issue) {
    $issue->dispatch=1;
    date_default_timezone_set('Asia/Kolkata');
    $date= date('Y-m-d');
    $time= date('H:i:s');
    $issue->dispatch_date=$date.' '.$time;
    $issue->save();

    $session->message("The Vehicle has been dispatched successfully!");
    redirect("view-requests.php");
} else {
    redirect("view-requests.php");
}

