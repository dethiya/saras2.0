<?php
$page_title='Deliveries Notification';
include '../includes/init.php';
if (!$session->is_signed_in()) {redirect("login.php");}

$session_user = User::find($session->user_id);

if ($session_user->role=='administrator'){
    $sql="select * from dispatches where delivery_date=CURDATE()";
}else{
    $sql="select * from dispatches where delivery_date=CURDATE() and delr='$session_user->outlet_id'";
}
$result=$database->query($sql);
echo json_encode($result->num_rows);


