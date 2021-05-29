<?php
    $page_title='Notification';
    include '../includes/init.php';
    if (!$session->is_signed_in()) {redirect("login.php");}

    $sql="select * from indents where is_approved=0";
    $result=$database->query($sql);
    echo json_encode($result->num_rows);


