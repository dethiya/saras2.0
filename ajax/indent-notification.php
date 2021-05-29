<?php
$page_title='Indent Notification';
include '../includes/init.php';
if (!$session->is_signed_in()) {redirect("login.php");}

    $indent=Indent::select('*','','id desc');

foreach ($indent as $list)
    {
        $get_users=User::find($list->request_user_id);
        $get_vehicle=Stock::find($list->vehicle_id);
        $get_variant=Variant::find_variant($get_vehicle->model_code);
        $get_color=Color::find_color($get_vehicle->color);
?>
        <div class="left">
            <span class="date-time"><?=date('d-m-Y H:i:s A',strtotime($list->datetime))?></span>
            <a href="javascript:;" class="name"><?=$get_users->employee_name?></a>
            <a href="javascript:;" class="image"><img alt="" src="<?=$get_users->image_path_and_placeholder();?>" /></a>
            <div class="message">
                Requested for Branch Transfer from <a href=""><?=$list->existing_outlet_code?></a> for <?=$get_variant->variant_name?> (<?=$get_color->color_name?>) Chassis # <a href=""><?=$get_vehicle->chassis_no?></a> & Engine #: <a href=""><?=$get_vehicle->engine_no?></a>
            </div>
        </div>
<?php     } ?>



