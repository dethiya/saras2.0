<?php

include("../includes/header.php");
if (!$session->is_signed_in()) {redirect("login.php");}

if(empty($_GET['id'])) {
    redirect("../models.php");
}

$model = Model::find($_GET['id']);

if($model) {
    $model->delete();
    $session->message('The Model has been deleted successfully!');
    redirect("../models.php");
} else {
    redirect("../models.php");
}
?>
