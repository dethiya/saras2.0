<?php
$page_title='Notification';
include '../includes/init.php';
if (!$session->is_signed_in()) {redirect("login.php");}

$session_user = User::find($session->user_id);


$result=$database->query($sql);
echo json_encode($result->num_rows);


