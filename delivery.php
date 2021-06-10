<?php

include("includes/header.php");
if (!$session->is_signed_in()) {redirect("login.php");}

if(empty($_GET['id'])) {
    redirect("deliveries.php");
}
$get_vehicle_id=$_GET['id'];
$allotment = Stock::find($get_vehicle_id);
$history=new AllotHistory();
if($allotment) {
    $history->vehicle_id=$get_vehicle_id;
    $history->allot_status_id=5;
    $history->allotment_dt=$allotment->allotment_dt;
    $history->customer_name= $allotment->customer_name;
    $history->srm_id=$allotment->srm_id;
    $history->rm_id=$allotment->rm_id;
    $history->allotment_remark=$allotment->allotment_remark;
    $history->updated_by=$session->user_id;

    date_default_timezone_set('Asia/Kolkata');
    $date= date('Y-m-d');
    $time= date('H:i:s');
    $history->updated_at=$date.' '.$time;
    $history->save();

    $allotment->allot_status_id=5;
    $allotment->stock_location=18;
    $allotment->delivery_date=$date;
    $allotment->delivery_datetime=$history->updated_at;
    $allotment->save();


    // $session->message("The Vehicle bearing chassis no. {$allotment->chassis_prefix}{$allotment->chassis_no} delivered successfully!");
    redirect("deliveries.php");
} else {
    redirect("deliveries.php");
}
?>
