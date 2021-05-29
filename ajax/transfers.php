<?php
$page_title='Notification';
include '../includes/init.php';
if (!$session->is_signed_in()) {redirect("login.php");}

$session_user = User::find($session->user_id);

if ($session_user->role=='administrator'){
    $sql="select * from dispatches where allot_status_id=3";
}else{
    $sql="select * from dispatches where allot_status_id=3 and delr='$session_user->outlet_id'";
}
$result=$database->query($sql);
echo json_encode($result->num_rows);


