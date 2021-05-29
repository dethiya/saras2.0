<?php
$page_title='Indent Notification';
include '../includes/init.php';
if (!$session->is_signed_in()) {redirect("login.php");}
$session_user = User::find($session->user_id);

if ($session_user->role=='administrator'){
//    $sql="select * from dispatches where allotment_dt=CURDATE()";
    $allotment=Stock::select('*','allotment_dt=CURDATE()');
}else{
    $allotment=Stock::select('*','allotment_dt=CURDATE() and delr="'.$session_user->outlet_id.'"');
//    $sql="select * from dispatches where allotment_dt=CURDATE() and delr='$session_user->outlet_id'";
}

foreach ($allotment as $value)
    {
        $get_variant=Variant::find_variant($value->model_code);
        $get_color=Color::find_color($value->color);
        $get_outlet=Outlet::find_outlet($value->delr);
?>
        <a href="allotment-history.php?id=<?=$value->id?>" class="dropdown-item media">
            <div class="media-left">
                <i class="fa fa-tags media-object bg-silver-darker"></i>
            </div>
            <div class="media-body">
                <h6 class="media-heading">

                    <?php
                    echo $get_variant->variant_name.' '.$get_color->color_name.'<br>';
                    echo 'CH. NO. '.$value->chassis_no.' EN. NO. '.$value->engine_no.'<br>';
                    echo 'alloted to '.$value->customer_name;
                    ?>
<i class="fa fa-exclamation-circle text-danger"></i></h6>
            </div>
        </a>
<?php     } ?>



