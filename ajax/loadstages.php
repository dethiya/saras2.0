<?php
$page_title='Load Stages';
include '../includes/init.php';
if (!$session->is_signed_in()) {redirect("login.php");}

if (isset($_POST['finance_value'])){
    if($_POST['finance_value']=="Yes"){
        $stages=FinStage::select('*','state=1');
        //select(rows,where)
    }else{
        $stages=FinStage::select('*','state=0');
    }
}
echo json_encode($stages);

