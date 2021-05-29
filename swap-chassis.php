<?php
$page_title='Vehicle Swapping';
$allotment_class='active';

include 'includes/header.php';
if (!$session->is_signed_in()) {redirect("login.php");}
include 'includes/top_nav.php';
include 'includes/sidebar.php';
$statusMsg='';
$type='';
$statusType='';
$chassis_prev='';
$chassis_next='';
if(isset($_POST['swap'])){
    $chassis_prev=$_POST['chassis_prev'];
    $chassis_next=$_POST['chassis_next'];

    if(empty($chassis_prev) || empty($chassis_next)){
        $msg='Please select both the Chassis to swap.';
    }else{
        $chassis_prev_details=Stock::find($chassis_prev);
        $chassis_next_details=Stock::find($chassis_next);
        $old_chassis= $chassis_prev_details->id;
        $old_chassis_no= $chassis_prev_details->chassis_no;
        $new_chassis= $chassis_next_details->id;
        $new_chassis_no= $chassis_next_details->chassis_no;

        $swap_query="UPDATE dispatches AS dispatches1 ";
        $swap_query.=" JOIN dispatches AS dispatches2 ON (dispatches1.id = ".$old_chassis." AND dispatches2.id = ".$new_chassis.") ";
        $swap_query.=" OR (dispatches1.id = ".$new_chassis." AND dispatches2.id = ".$old_chassis.") ";
        $swap_query.=" SET dispatches1.allot_status_id = dispatches2.allot_status_id, dispatches2.allot_status_id = dispatches1.allot_status_id,";
        $swap_query.=" dispatches1.customer_name = dispatches2.customer_name, dispatches2.customer_name = dispatches1.customer_name,";
//        rm & srm
        $swap_query.=" dispatches1.srm_id = dispatches2.srm_id, dispatches2.srm_id = dispatches1.srm_id,";
        $swap_query.=" dispatches1.rm_id = dispatches2.rm_id, dispatches2.rm_id = dispatches1.rm_id,";
//        allotment
        $swap_query.=" dispatches1.allotment_remark = 'Chassis swapped from $new_chassis_no', dispatches2.allotment_remark = 'Chassis swapped from $new_chassis_no',";
        $swap_query.=" dispatches1.allotment_dt = dispatches2.allotment_dt, dispatches2.allotment_dt = dispatches1.allotment_dt,";
//        sms & dms
        $swap_query.=" dispatches1.sms_inv_no = dispatches2.sms_inv_no, dispatches2.sms_inv_no = dispatches1.sms_inv_no,";
        $swap_query.=" dispatches1.sms_inv_dt = dispatches2.sms_inv_dt, dispatches2.sms_inv_dt = dispatches1.sms_inv_dt,";
        $swap_query.=" dispatches1.dms_inv_no = dispatches2.dms_inv_no, dispatches2.dms_inv_no = dispatches1.dms_inv_no,";
        $swap_query.=" dispatches1.dms_inv_dt = dispatches2.dms_inv_dt, dispatches2.dms_inv_dt = dispatches1.dms_inv_dt,";
//        finance
        $swap_query.=" dispatches1.fin_is_fin_req = dispatches2.fin_is_fin_req, dispatches2.fin_is_fin_req = dispatches1.fin_is_fin_req,";
        $swap_query.=" dispatches1.fin_fin_type = dispatches2.fin_fin_type, dispatches2.fin_fin_type = dispatches1.fin_fin_type,";
        $swap_query.=" dispatches1.fin_bank_id = dispatches2.fin_bank_id, dispatches2.fin_bank_id = dispatches1.fin_bank_id,";
        $swap_query.=" dispatches1.fin_stage = dispatches2.fin_stage, dispatches2.fin_stage = dispatches1.fin_stage,";
        $swap_query.=" dispatches1.fin_stage_dt = dispatches2.fin_stage_dt, dispatches2.fin_stage_dt = dispatches1.fin_stage_dt,";
        $swap_query.=" dispatches1.remark_one = dispatches2.remark_one, dispatches2.remark_one = dispatches1.remark_one,";
        $swap_query.=" dispatches1.remark_two = dispatches2.remark_two, dispatches2.remark_two = dispatches1.remark_two,";
//        exchange
        $swap_query.=" dispatches1.is_exchange = dispatches2.is_exchange, dispatches2.is_exchange = dispatches1.is_exchange,";
        $swap_query.=" dispatches1.exch_status = dispatches2.exch_status, dispatches2.exch_status = dispatches1.exch_status,";
        $swap_query.=" dispatches1.exch_date = dispatches2.exch_date, dispatches2.exch_date = dispatches1.exch_date,";
        $swap_query.=" dispatches1.exch_remark = dispatches2.exch_remark, dispatches2.exch_remark = dispatches1.exch_remark,";
//        delivery
        $swap_query.=" dispatches1.delivery_date = dispatches2.delivery_date, dispatches2.delivery_date = dispatches1.delivery_date,";
        $swap_query.=" dispatches1.delivery_datetime = dispatches2.delivery_datetime, dispatches2.delivery_datetime = dispatches1.delivery_datetime";

        $swap_result=$database->query($swap_query);
        if($swap_result){
            $type='Success';
            $statusType = 'alert-success';
            $statusMsg = 'Vehicles swapped successfully.';
            $pre_vehicle=Stock::find($old_chassis);
            $next_vehicle=Stock::find($new_chassis);

        }else{
            $type='Error';
            $statusType = 'alert-danger';
            $statusMsg = 'Oops. Something went wrong.';
        }

    }



}
?>
    <div id="content" class="content">
        <ol class="breadcrumb float-xl-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="allotment.php">Allotment</a></li>
            <li class="breadcrumb-item active"><?=$page_title?></li>
        </ol>
<?php if ($statusMsg): ?>
    <div class="alert <?=$statusType?> fade show">
        <span class="close" data-dismiss="alert">×</span>
        <strong><?=$type?>!</strong>
        <?=$statusMsg?>
        <a href="#" class="alert-link"></a>
    </div>
<?php endif; ?>
        <h1 class="page-header"><?=$page_title?></h1>
        <div class="row">
            <div class="col-xl-12">
                    <div class="panel panel-inverse" data-sortable-id="form-validation-1">

                        <div class="panel-heading">
                            <h4 class="panel-title">Select Vehicles Chassis to be Swapped  </h4>
                            <div class="panel-heading-btn">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                            </div>
                        </div>



                        <div class="panel-body">
                            <form class="form-inline" action="" method="POST">
                                <div class="form-group m-r-10">
                                    <select class="form-control" name="chassis_prev" id="" autofocus>
                                        <option value="">-Select Old Chassis-</option>
                                        <?php
                                        $getChassis=Stock::select('*','allot_status_id<>5 or allot_status_id<>6 and delr="{$session_user->outlet_id}"','customer_name, chassis_no asc');
                                        foreach ($getChassis as $value){
                                            if(empty($value->customer_name)){
                                                $customer='';
                                            }else{
                                                $customer=$value->customer_name;
                                            }
                                            echo '<option value="'.$value->id.'">'.$value->chassis_no.' '.$customer.'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group m-r-10">
                                    <select class="form-control" name="chassis_next" id="">
                                        <option value="">-Select New Chassis-</option>
                                        <?php
                                        $getChassis=Stock::select('*','allot_status_id<>5 or allot_status_id<>6 and delr="{$session_user->outlet_id}"','customer_name, chassis_no asc');
                                        foreach ($getChassis as $value){
                                            if(empty($value->customer_name)){
                                                $customer='';
                                            }else{
                                                $customer=$value->customer_name;
                                            }
                                            echo '<option value="'.$value->id.'">'.$value->chassis_no.' '.$customer.'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <button type="submit" name="swap" class="btn btn-sm btn-primary m-r-5"><i class="fa fa-check"></i> Swap Chassis</button>
<!--                                <button type="submit" class="btn btn-sm btn-default">Register</button>-->
                            </form>
                        </div>

                    </div>

            </div>

<?php include 'includes/footer.php';?>