<?php

include("includes/header.php");
if (!$session->is_signed_in()) {redirect("login.php");}

if(empty($_GET['id'])) {
    redirect("indents.php");
}
$get_indent_id=$_GET['id'];
$receive = Indent::find($get_indent_id);
$allotment=Stock::find($receive->vehicle_id);
if($receive) {
    $receive->dispatch=2;
    date_default_timezone_set('Asia/Kolkata');
    $date= date('Y-m-d');
    $time= date('H:i:s');
    $receive->receive_date=$date.' '.$time;
    $receive->received_by=$session_user->id;
    $receive->save();

    $allotment->delr=$receive->request_outlet_id;
    $allotment->save();

    $session->message("The Vehicle has been dispatched successfully!");
    redirect("indents.php");
} else {
    redirect("indents.php");
}

