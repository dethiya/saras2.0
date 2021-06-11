<?php

include("includes/header.php");
if (!$session->is_signed_in()) {redirect("login.php");}


$get_vehicle_id=$_POST['vehicle_id'];

echo $get_vehicle_id;

$allotment = Stock::find($get_vehicle_id);
$history=new AllotHistory();
if($allotment) {
    $history->vehicle_id=$get_vehicle_id;
    $history->allot_status_id=6;
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

    $allotment->allot_status_id=4;
    $allotment->allotment_dt=NULL;
    $allotment->customer_name='';
    $allotment->srm_id=0;
    $allotment->rm_id=0;
    $allotment->allotment_remark='';
    $allotment->fin_is_fin_req='';
    $allotment->fin_fin_type='';
    $allotment->fin_bank_id=0;
    $allotment->fin_stage=0;
    $allotment->fin_stage_dt=NULL;
    $allotment->sms_inv_no='';
    $allotment->sms_inv_dt=NULL;
    $allotment->dms_inv_no='';
    $allotment->dms_inv_dt=NULL;
    $allotment->is_exchange='';
    $allotment->exch_status=0;
    $allotment->exch_date=NULL;
    $allotment->mssf_id           ='';
    $allotment->mssf_login_dt     =NULL;
    $allotment->branch            ='';
    $allotment->bank_executive    ='';
    $allotment->remark_one        ='';
    $allotment->customer_mobile_no='';
    $allotment->save();

    // $session->message("The Vehicle with chassis no. {$allotment->chassis_no} & engine no. {$allotment->engine_no} has been dealloted successfully!");
    // redirect("allotment.php");
} else {
    redirect("allotment.php");
}
