<?php

include("includes/header.php");
if (!$session->is_signed_in()) {redirect("login.php");}

if(empty($_GET['id'])) {
    redirect("indents.php");
}
$get_vehicle_id=$_GET['id'];
$allotment = Stock::find($get_vehicle_id);
$indent=new Indent();
if($allotment) {
    $indent->vehicle_id=$get_vehicle_id;
    $indent->request_user_id=$session_user->id;
    $indent->request_outlet_id= $session_user->outlet_id;
    $indent->existing_outlet_code= $allotment->delr;

    date_default_timezone_set('Asia/Kolkata');
    $date= date('Y-m-d');
    $time= date('H:i:s');
    $indent->datetime=$date.' '.$time;
    $indent->save();

    $session->message("The Indent for Vehicle with chassis no. {$allotment->chassis_no} & engine no. {$allotment->engine_no} has been raised successfully!");
    redirect("indents.php");
} else {
    redirect("indents.php");
}
?>
