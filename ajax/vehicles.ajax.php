<?php
$page_title='Notification';
include '../includes/init.php';


if (isset($_POST["vehicle_status"])) {

	$vehice_status = $_POST["vehicle_status"];
    $vehicle_id = $_POST["vehicle_id"];
    
    $sql="UPDATE dispatches SET type=".$vehice_status." WHERE id=".$vehicle_id;
    $answer=$database->query($sql);
    
}
