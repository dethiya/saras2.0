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
        $swap_query.=" dispatches1.allotment_remark = 'Chassis swapped $chassis_prev_details->chassis_no.', dispatches2.allotment_remark = 'Chassis swapped $chassis_prev_details->chassis_no.',";
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
        $swap_query.=" dispatches1.branch = dispatches2.branch, dispatches2.branch = dispatches1.branch,";
        $swap_query.=" dispatches1.mssf_id = dispatches2.mssf_id, dispatches2.mssf_id = dispatches1.mssf_id,";
        $swap_query.=" dispatches1.mssf_login_dt = dispatches2.mssf_login_dt, dispatches2.mssf_login_dt = dispatches1.mssf_login_dt,";
        $swap_query.=" dispatches1.bank_executive = dispatches2.bank_executive, dispatches2.bank_executive = dispatches1.bank_executive,";
        $swap_query.=" dispatches1.customer_mobile_no = dispatches2.customer_mobile_no, dispatches2.customer_mobile_no = dispatches1.customer_mobile_no,";
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
            
            // add allotment history
            $allot_history=new AllotHistory();
            $allot_history->vehicle_id        =$pre_vehicle->id;
            $allot_history->allot_status_id   =$pre_vehicle->allot_status_id;
            $allot_history->allotment_dt      =$pre_vehicle->allotment_dt;
            $allot_history->customer_name     =$pre_vehicle->customer_name;
            $allot_history->srm_id            =$pre_vehicle->srm_id;
            $allot_history->rm_id             =$pre_vehicle->rm_id;
            $allot_history->remarks  ='Customer chassis swapped. Previous chassis: '.$new_chassis_no;
            $allot_history->updated_by        =$session->user_id;
            $date= date('Y-m-d');
            $time= date('H:i:s');
            $allot_history->updated_at=$date.' '.$time;
            $allot_history->save();

            // add allotment history vehicle 2
            $allot_history=new AllotHistory();
            $allot_history->vehicle_id        =$next_vehicle->id;
            $allot_history->allot_status_id   =$next_vehicle->allot_status_id;
            $allot_history->allotment_dt      =$next_vehicle->allotment_dt;
            $allot_history->customer_name     =$next_vehicle->customer_name;
            $allot_history->srm_id            =$next_vehicle->srm_id;
            $allot_history->rm_id             =$next_vehicle->rm_id;
            $allot_history->remarks  ='Customer chassis swapped. Previous chassis: '.$old_chassis_no;
            $allot_history->updated_by        =$session->user_id;
            $date= date('Y-m-d');
            $time= date('H:i:s');
            $allot_history->updated_at=$date.' '.$time;
            $allot_history->save();

            // add finance history vehicle 1
            $fin_history=new FinanceHistory();
            $fin_history->vehicle_id        = $pre_vehicle->id;
            $fin_history->allotment_dt      = $pre_vehicle->allotment_dt;
            $fin_history->customer_name     = $pre_vehicle->customer_name;
            $fin_history->fin_is_fin_req    = $pre_vehicle->fin_is_fin_req;
            $fin_history->mssf_id           = $pre_vehicle->mssf_id;
            $fin_history->mssf_login_dt      = $pre_vehicle->mssf_login_dt;
            $fin_history->fin_fin_type      = $pre_vehicle->fin_fin_type;
            $fin_history->fin_bank_id       = $pre_vehicle->fin_bank_id;
            $fin_history->branch            = $pre_vehicle->branch;
            $fin_history->bank_executive    = $pre_vehicle->bank_executive;
            $fin_history->fin_stage         = $pre_vehicle->fin_stage;
            $fin_history->fin_stage_dt      = $pre_vehicle->fin_stage_dt;
            $fin_history->remark_one        = 'Customer chassis swapped. Previous chassis: '.$new_chassis_no;
            $fin_history->customer_mobile_no= $pre_vehicle->customer_mobile_no;
            $fin_history->updated_by        = $session->user_id;
            $date= date('Y-m-d');
            $time= date('H:i:s');
            $fin_history->updated_at        = $date.' '.$time;
            $fin_history->save();

            // add finance history vehicle 2
            $fin_history=new FinanceHistory();
            $fin_history->vehicle_id        = $next_vehicle->id;
            $fin_history->allotment_dt      = $next_vehicle->allotment_dt;
            $fin_history->customer_name     = $next_vehicle->customer_name;
            $fin_history->fin_is_fin_req    = $next_vehicle->fin_is_fin_req;
            $fin_history->mssf_id           = $next_vehicle->mssf_id;
            $fin_history->mssf_login_dt      = $next_vehicle->mssf_login_dt;
            $fin_history->fin_fin_type      = $next_vehicle->fin_fin_type;
            $fin_history->fin_bank_id       = $next_vehicle->fin_bank_id;
            $fin_history->branch            = $next_vehicle->branch;
            $fin_history->bank_executive    = $next_vehicle->bank_executive;
            $fin_history->fin_stage         = $next_vehicle->fin_stage;
            $fin_history->fin_stage_dt      = $next_vehicle->fin_stage_dt;
            $fin_history->remark_one        = 'Customer chassis swapped. Previous chassis: '.$old_chassis_no;
            $fin_history->customer_mobile_no= $next_vehicle->customer_mobile_no;
            $fin_history->updated_by        = $session->user_id;
            $date= date('Y-m-d');
            $time= date('H:i:s');
            $fin_history->updated_at        = $date.' '.$time;
            $fin_history->save();

            // add exchange history of vehicle 1
            $exch_history=new ExchangeHistory();
            $exch_history->vehicle_id        = $pre_vehicle->id;
            $exch_history->allotment_dt      = $pre_vehicle->allotment_dt;
            $exch_history->customer_name     = $pre_vehicle->customer_name;
            $exch_history->is_exchange       = $pre_vehicle->is_exchange;
            $exch_history->exch_status       = $pre_vehicle->exch_status;
            $exch_history->exch_date         = $pre_vehicle->exch_date;
            $exch_history->exch_remark       = 'Customer chassis swapped. Previous chassis: '.$new_chassis_no;
            $exch_history->updated_by        = $session->user_id;
            $date= date('Y-m-d');
            $time= date('H:i:s');
            $exch_history->updated_at        = $date.' '.$time;
            $exch_history->save();

            
            // add exchange history of vehicle 2
            $exch_history=new ExchangeHistory();
            $exch_history->vehicle_id        = $next_vehicle->id;
            $exch_history->allotment_dt      = $next_vehicle->allotment_dt;
            $exch_history->customer_name     = $next_vehicle->customer_name;
            $exch_history->is_exchange       = $next_vehicle->is_exchange;
            $exch_history->exch_status       = $next_vehicle->exch_status;
            $exch_history->exch_date         = $next_vehicle->exch_date;
            $exch_history->exch_remark       = 'Customer chassis swapped. Previous chassis: '.$old_chassis_no;
            $exch_history->updated_by        = $session->user_id;
            $date= date('Y-m-d');
            $time= date('H:i:s');
            $exch_history->updated_at        = $date.' '.$time;
            $exch_history->save();


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
                <div class="panel panel-inverse shadow" data-sortable-id="form-validation-1">
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
                        <form class="" action="" method="POST">
                            <div class="form-group m-r-10">
                            <label for="">Old Chassis</label>
                                <select class="form-control" name="chassis_prev" id="chassis_prev" autofocus>
                                <option value="">Search by Variant Name/Color Name/Chassis/Customer/Ageing</option>
                                    <?php
                                        $getChassis=Stock::select('*','allot_status_id<>5 and delr="'.$session_user->outlet_id.'"','model_code, color, invoice_dt asc');
    
                                        foreach ($getChassis as $value){
    
                                            $MSIL_dispatch_date = new DateTime(date('d-m-Y',strtotime($value->invoice_dt)));
                                            $current_date = new DateTime();
                                            $vintage = $current_date->diff($MSIL_dispatch_date)->format("%a");
                                            
                                            $getVariant=Variant::select('*','variant_code="'.$value->model_code.'"');
                                            $get_color=Color::find_color($value->color);
                                            if(empty($value->customer_name)){
                                                $customer='-';
                                            }else{
                                                $customer=$value->customer_name;
                                            }
                                            echo '<option value="'.$value->id.'" data-vintage="Ageing: '.$vintage.'">'.$getVariant[0]->variant_name.' / '.$get_color->color_name.' / '.$value->chassis_no.' /  '.$customer.' / '.$vintage.' Days</option>';
                                        }
                                    ?>
                                </select>
                                <strong><div class="text-danger vintage-target"></div></strong>
                            </div>
                            
                            <div class="form-group m-r-10">
                            <label for="">New Chassis</label>
                                <select class="form-control" name="chassis_next" id="chassis_next">
                                    <option value="">Search by Variant Name/Color Name/Chassis/Customer/Ageing</option>
                                    <?php
                                        $getChassis=Stock::select('*','allot_status_id<>5 and delr="'.$session_user->outlet_id.'"','model_code, color, invoice_dt asc');
    
                                        foreach ($getChassis as $value){
    
                                            $MSIL_dispatch_date = new DateTime(date('d-m-Y',strtotime($value->invoice_dt)));
                                            $current_date = new DateTime();
                                            $vintage = $current_date->diff($MSIL_dispatch_date)->format("%a");
                                            
                                            $getVariant=Variant::select('*','variant_code="'.$value->model_code.'"');
                                            $get_color=Color::find_color($value->color);
                                            if(empty($value->customer_name)){
                                                $customer='-';
                                            }else{
                                                $customer=$value->customer_name;
                                            }
                                            echo '<option value="'.$value->id.'" data-vintage="Ageing: '.$vintage.'">'.$getVariant[0]->variant_name.' / '.$get_color->color_name.' / '.$value->chassis_no.' /  '.$customer.' / '.$vintage.' Days</option>';
                                        }
                                    ?>
                                </select>
                                <strong><div class="text-danger vintage-target2"></div></strong>
                            </div>
                            <button type="submit" name="swap" class="btn btn-sm btn-primary m-r-5"><i class="fa fa-check"></i> Swap Chassis</button>
                        </form>
                    </div>
                </div>
            </div>

            <?php 
                $pre_vehicle=Stock::find($chassis_prev); 
                $next_vehicle=Stock::find($chassis_next);
            ?>
            <div class="col-xl-6">
                <?php if($pre_vehicle):?>
                <div class="panel panel-inverse shadow" data-sortable-id="table-basic-1">
                    <div class="panel-heading">
                        <h4 class="panel-title"><strong>Old Chassis / Engine:</strong> <?=$pre_vehicle->chassis_no.' / '.$pre_vehicle->engine_no?> </h4>
                        <div class="panel-heading-btn">
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table m-b-0">
                                <thead>
                                    <tr>
                                        <th width=25%>Parameters</th>
                                        <th>Values</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <tr>
                                        <th>Vehicle:</th>
                                        <td>
                                        <?php 
                                                $getPreVariant=Variant::find_variant($pre_vehicle->model_code);
                                                $getPreColor=Color::find_color($pre_vehicle->color);
                                                
                                            ?>
                                        <strong>Variant / Variant Code: </strong> <?=$getPreVariant->variant_name.' / '.$pre_vehicle->model_code?> <br>
                                        <strong>Color / Color Code: </strong> <?=$getPreColor->color_name.' / '.$pre_vehicle->color?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>VIN:</th>
                                        <td><?=$pre_vehicle->chassis_prefix.$pre_vehicle->chassis_no?></td>
                                    </tr>
                                    <tr>
                                        <th>Engine:</th>
                                        <td><?=$pre_vehicle->engine_no?></td>
                                    </tr>
                                    <tr>
                                        <th>Customer Name:</th>
                                        <td><?=$pre_vehicle->allot_status_id==4?'-':ucwords(strtolower($pre_vehicle->customer_name))?></td>
                                    </tr>
                                    <tr>
                                        <th>Allotment Details:</th>
                                        <td>
                                            <strong>Status:</strong> 
                                            <?php 
                                                $allot_status=AllotStatus::find($pre_vehicle->allot_status_id);
                                                echo $allot_status->status;
                                            ?> <br>
                                            <strong>Date:</strong> <?=$pre_vehicle->allot_status_id==4?'-/-/-':date('d-M-y',strtotime($pre_vehicle->allotment_dt))?> <br>
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>SRM:</th>
                                        <td>
                                            <?php
                                                $srm=Srm::find($pre_vehicle->srm_id);
                                                echo $pre_vehicle->srm_id>0?$srm->srm_name:'---';
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>RM:</th>
                                        <td>
                                        <?php
                                                $rm=Rm::find($pre_vehicle->rm_id);
                                                echo $pre_vehicle->rm_id>0?$rm->rm_name:'---';
                                            ?>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <th>Finance:</th>
                                        <td>
                                            <strong>Required:</strong> 
                                            <?=empty($pre_vehicle->fin_is_fin_req)?'---':$pre_vehicle->fin_is_fin_req?> <br>
                                            <strong>MSSF ID:</strong> 
                                            <?=empty($pre_vehicle->mssf_id)?'---':$pre_vehicle->mssf_id?> <br>
                                            <strong>MSSF Login Dt: </strong>
                                            <?=empty($pre_vehicle->mssf_id)?'---':$pre_vehicle->mssf_login_dt?> <br>
                                            <strong>Type:</strong> 
                                            <?=empty($pre_vehicle->fin_fin_type)?'---':$pre_vehicle->fin_fin_type  ?><br>
                                            <strong>Bank:</strong> 
                                            <?php
                                                $bank=Bank::find($pre_vehicle->fin_bank_id);
                                                echo $pre_vehicle->fin_bank_id>0?$bank->bank_name:'---'; 
                                                   
                                            ?>
                                                <br>
                                            <strong>Branch:</strong> <?=empty($pre_vehicle->branch)?'---':$pre_vehicle->branch        ?><br>
                                            <strong>Bank Executive:</strong> <?=empty($pre_vehicle->bank_executive)?'---':$pre_vehicle->bank_executive?><br>
                                            <strong>Stage:</strong> 
                                            <?php 
                                                $getFinStage=FinStage::find($pre_vehicle->fin_stage);
                                                echo $pre_vehicle->fin_stage>0?$getFinStage->stage_name:'---';
                                            ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Exchange:</th>
                                        <td>
                                            <strong>Required:</strong> <?=empty($pre_vehicle->is_exchange)?'---':$pre_vehicle->is_exchange?> <br>
                                            <strong>MSSF ID:</strong> 
                                            <?php 
                                                $getExchStage=ExchangeStatus::find($pre_vehicle->exch_status);
                                                echo $pre_vehicle->exch_status>0?$getExchStage->status_desc:'---';
                                            
                                            ?> <br>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php endif;?>                
                
                </div>
                <div class="col-xl-6">
                    <?php if($pre_vehicle):?>
                    <div class="panel panel-inverse shadow" data-sortable-id="table-basic-1">
                        <div class="panel-heading">
                            <h4 class="panel-title"><strong>New Chassis / Engine:</strong> <?=$next_vehicle->chassis_no.' / '.$next_vehicle->engine_no?></h4>
                            <div class="panel-heading-btn">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                            <table class="table m-b-0">
                                <thead>
                                    <tr>
                                        <th width=25%>Parameters</th>
                                        <th>Values</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <tr>
                                        <th>Vehicle:</th>
                                        <td>
                                        <?php 
                                                $getPreVariant=Variant::find_variant($pre_vehicle->model_code);
                                                $getPreColor=Color::find_color($pre_vehicle->color);
                                                
                                            ?>
                                        <strong>Variant / Variant Code: </strong> <?=$getPreVariant->variant_name.' / '.$pre_vehicle->model_code?> <br>
                                        <strong>Color / Color Code: </strong> <?=$getPreColor->color_name.' / '.$pre_vehicle->color?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>VIN:</th>
                                        <td><?=$next_vehicle->chassis_prefix.$next_vehicle->chassis_no?></td>
                                    </tr>
                                    <tr>
                                        <th>Engine:</th>
                                        <td><?=$next_vehicle->engine_no?></td>
                                    </tr>
                                    <tr>
                                        <th>Customer Name:</th>
                                        <td><?=$next_vehicle->allot_status_id==4?'-':ucwords(strtolower($next_vehicle->customer_name))?></td>
                                    </tr>
                                    <tr>
                                        <th>Allotment Details:</th>
                                        <td>
                                            <strong>Status:</strong> 
                                            <?php 
                                                $allot_status=AllotStatus::find($next_vehicle->allot_status_id);
                                                echo $allot_status->status;
                                            ?> <br>
                                            <strong>Date:</strong> <?=$next_vehicle->allot_status_id==4?'-/-/-':date('d-M-y',strtotime($next_vehicle->allotment_dt))?> <br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>SRM:</th>
                                        <td>
                                            <?php
                                                $srm=Srm::find($next_vehicle->srm_id);
                                                echo $next_vehicle->srm_id>0?$srm->srm_name:'---';
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>RM:</th>
                                        <td>
                                        <?php
                                                $rm=Rm::find($next_vehicle->rm_id);
                                                echo $next_vehicle->rm_id>0?$rm->rm_name:'---';
                                            ?>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <th>Finance:</th>
                                        <td>
                                            <strong>Required:</strong> 
                                            <?=empty($next_vehicle->fin_is_fin_req)?'---':$next_vehicle->fin_is_fin_req?> <br>
                                            <strong>MSSF ID:</strong> 
                                            <?=empty($next_vehicle->mssf_id)?'---':$next_vehicle->mssf_id?> <br>
                                            <strong>MSSF Login Dt: </strong>
                                            <?=empty($next_vehicle->mssf_id)?'---':$next_vehicle->mssf_login_dt?> <br>
                                            <strong>Type:</strong> 
                                            <?=empty($next_vehicle->fin_fin_type)?'---':$next_vehicle->fin_fin_type  ?><br>
                                            <strong>Bank:</strong> 
                                            <?php
                                                $bank=Bank::find($next_vehicle->fin_bank_id);
                                                echo $next_vehicle->fin_bank_id>0?$bank->bank_name:'---'; 
                                                   
                                            ?>
                                                <br>
                                            <strong>Branch:</strong> <?=empty($next_vehicle->branch)?'---':$next_vehicle->branch        ?><br>
                                            <strong>Bank Executive:</strong> <?=empty($next_vehicle->bank_executive)?'---':$next_vehicle->bank_executive?><br>
                                            <strong>Stage:</strong> 
                                            <?php 
                                                $getFinStage=FinStage::find($next_vehicle->fin_stage);
                                                echo $next_vehicle->fin_stage>0?$getFinStage->stage_name:'---';
                                            ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Exchange:</th>
                                        <td>
                                            <strong>Required:</strong> <?=empty($next_vehicle->is_exchange)?'---':$next_vehicle->is_exchange?> <br>
                                            <strong>MSSF ID:</strong> 
                                            <?php 
                                                $getExchStage=ExchangeStatus::find($next_vehicle->exch_status);
                                                echo $next_vehicle->exch_status>0?$getExchStage->status_desc:'---';
                                            
                                            ?> <br>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>                    
                    <?php endif;?>
                </div>

            
        </div>
            </div>

        </div>

<?php include 'includes/footer.php';?>