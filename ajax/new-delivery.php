<?php




$page_title='Indent Notification';
include '../includes/init.php';
if (!$session->is_signed_in()) {redirect("login.php");}
$session_user = User::find($session->user_id);

if ($session_user->role=='administrator'){
//    $sql="select * from dispatches where allotment_dt=CURDATE()";
    $allotment=Stock::select('*','delivery_date=CURDATE()','delivery_datetime desc','6');
}else{
    $allotment=Stock::select('*','delivery_date=CURDATE() and delr="'.$session_user->outlet_id.'"','delivery_datetime desc');
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
                <i class="fa fa-gift media-object bg-silver-darker"></i>
            </div>
            <div class="media-body">
                <h6 class="media-heading">

                    <?php

                    if($session_user->role=='administrator'){
                        echo '<strong>'.$get_outlet->outlet_name.'</strong> outlet delivered '.$get_variant->variant_name.'<br>';
                        echo ' to <strong>'.$value->customer_name.'</strong>';

                    }else{
                        echo $get_variant->variant_name.' delivered <br>';
                        echo ' to <strong>'.$value->customer_name.'</strong>';
                    }
                    ?>
                    <div class="text-muted">
                        <?=date('H:i:s A',strtotime($value->delivery_datetime))?>
                    </div>
            </div>
        </a>
<?php     } ?>



