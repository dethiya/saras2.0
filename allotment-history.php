<?php
$page_title='Vehicle History';
include 'includes/header.php';
if (!$session->is_signed_in()) {redirect("login.php");}
include 'includes/top_nav.php';
include 'includes/sidebar.php';

if (empty($_GET['id'])){
    redirect('index.php');
}

$allotment=Stock::find($_GET['id']);
$get_vehicle_id=$_GET['id'];
$variant=Variant::find_variant($allotment->model_code);
$bank=Bank::find($allotment->fin_bank_id);
$get_fin_stage=FinStage::find($allotment->fin_stage);
$get_stock_loc=StockLocation::find($allotment->stock_location);
$get_exch_status=ExchangeStatus::find($allotment->exch_status);
$get_color=Color::find_color($allotment->color);
$get_srm=Srm::find($allotment->srm_id);
$get_rm=Rm::find($allotment->rm_id);
$get_allotment_status=AllotStatus::find($allotment->allot_status_id);
?>
    <div id="content" class="content">
        <ol class="breadcrumb float-xl-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="">History</a></li>
            <li class="breadcrumb-item active"><?=$page_title?></li>
        </ol>
        <h1 class="page-header"><?=$page_title.' as on '.date('d-m-Y')?></h1>
        <div class="invoice">

            <div class="invoice-company">
                Variant: <?=$variant->variant_name.' ('.$allotment->model_code.') / Color: '.$get_color->color_name.' ('.$allotment->color.')';?>
                <br>
                VIN: <?=$allotment->chassis_prefix.$allotment->chassis_no?> /
                Engine No: <?=$allotment->engine_no?> <br />
            </div>

            <div class="invoice-header">
                <div class="invoice-from">
                    <address class="m-t-5 m-b-5">
                        <strong class="text-inverse">Current Vehicle Details<br /></strong>
                        Current Status: <?=$get_allotment_status->status?><br/>
                        Current Location: <?=$get_stock_loc->stock_loc_name?> <br/>
                        Dispatch Date: <?=date('d-m-Y',strtotime($allotment->invoice_dt))?><br />

                    </address>
                </div>
                <div class="invoice-from">
                    <address class="m-t-5 m-b-5">
                        <strong class="text-inverse">Current Finance Details<br /></strong>
                        Finance Required: <?=empty($allotment->fin_is_fin_req)?'-':$allotment->fin_is_fin_req?><br />
                        Finance Type: <?=empty($allotment->fin_fin_type)?'-':$allotment->fin_fin_type?><br />
                        Finance Bank: <?= $allotment->fin_bank_id>0?$bank->bank_name:'-'?> <br>
                        Finance Stage: <?=$allotment->fin_stage?$get_fin_stage->stage_name:'-'?><br />
                        Last Stage Recorded Date: <?=!empty($allotment->fin_is_fin_req)?date('d-m-Y', strtotime($allotment->fin_stage_dt)):'-'?> <br />
                    </address>
                </div>
                <div class="invoice-from">

                    <address class="m-t-5 m-b-5">
                        <strong class="text-inverse">Current Exchange Details</strong><br />
                        Is Exchange: <?=empty($allotment->is_exchange)?'-':$allotment->is_exchange?><br />
                        Exchange Status: <?=empty($allotment->exch_status)?'-':$get_exch_status->status_desc?><br />
                        Last Status Update Date: <?=!empty($allotment->is_exchange)?date('d-m-Y', strtotime($allotment->exch_date)):'-'?> <br>
                    </address>
                </div>
            </div>
<!--Allotment History-->
            <div class="invoice-content">
                <div class="col-xl-12">
                    <div class="panel panel-inverse" data-sortable-id="form-validation-1">
                        <div class="panel-heading">
                            <h4 class="panel-title">Allotment History</h4>
                            <div class="panel-heading-btn">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                            </div>
                        </div>

                        <div class="panel-body">
                            <table class="table table-responsive">
                                <thead>
                                <tr>
                                    <th width="1%">SN</th>
                                    <th width="1%" data-orderable="false">Allotment Status</th>
                                    <th class="text-nowrap">Allotment Date</th>
                                    <th class="text-nowrap">Customer Name</th>
                                    <th class="text-nowrap">SRM</th>
                                    <th class="text-nowrap">RM</th>
                                    <th class="text-nowrap">Remarks</th>
                                    <th class="text-nowrap">Updated By</th>
                                    <th class="text-nowrap">Updated At</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php
                                    $alt_history=AllotHistory::select('*','vehicle_id="'.$get_vehicle_id.'"','id DESC');
                                    foreach ($alt_history as $key=>$value):
                                ?>

                                <tr class="odd gradeX">
                                    <td width="1%" class="f-w-600 text-inverse"><?=$key+1?></td>
                                    <td width="1%" class="with-img">
                                        <?php $status=AllotStatus::find($value->allot_status_id); echo $status->status;?>
                                    </td>
                                    <td><?=$value->allotment_dt?></td>
                                    <td><?=$value->customer_name?></td>
                                    <td><?php $srm_name=Srm::find($value->srm_id); echo $srm_name->srm_name;?></td>
                                    <td><?php $rm_name=Rm::find($value->rm_id); echo $rm_name->rm_name;?></td>
                                    <td><?=$value->remarks?></td>
                                    <td><?php $user_name=User::find($value->updated_by); echo $user_name->employee_name;?></td>
                                    <td><?=$value->updated_at?></td>
                                </tr>
    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>
            </div>
<!--Finance History-->
    <div class="invoice-content">
        <div class="col-xl-12">
            <div class="panel panel-inverse" data-sortable-id="form-validation-1">
                <div class="panel-heading">
                    <h4 class="panel-title">Finance History</h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                </div>

                <div class="panel-body">
                    <table  class="table table-responsive">
                        <thead>
                        <tr>
                            <th width="1%">SN</th>
                            <th class="text-nowrap">Allotment Date</th>
                            <th class="text-nowrap">Customer Name</th>
                            <th class="text-nowrap">Finance Required</th>
                            <th class="text-nowrap">Finance Type</th>
                            <th class="text-nowrap">Financer</th>
                            <th class="text-nowrap">Finance Stage</th>
                            <th class="text-nowrap">Updated By</th>
                            <th class="text-nowrap">Updated At</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php
                        $alt_history=FinanceHistory::select('*','vehicle_id="'.$get_vehicle_id.'"','id DESC');
                        foreach ($alt_history as $key=>$value):
                            ?>

                            <tr class="odd gradeX">
                                <td width="1%" class="f-w-600 text-inverse"><?=$key+1?></td>
                                <td><?=$value->allotment_dt?></td>
                                <td><?=$value->customer_name?></td>
                                <td><?=$value->fin_is_fin_req?></td>
                                <td><?php
                                    if($value->fin_is_fin_req=='No'){
                                        echo 'Nil';
                                    }else{
                                        echo $value->fin_fin_type;
                                    }

                                    ?></td>
                                <td><?php
                                    $banks=Bank::find($value->fin_bank_id);
                                    $stages=FinStage::find($value->fin_stage);
                                    if($value->fin_is_fin_req=='No'){
                                        echo '-';
                                    }else{
                                        echo $banks->bank_name;
                                    }

                                    ?>
                                </td>
                                <td><?php
                                    $stages=FinStage::find($value->fin_stage);
                                    if($value->fin_is_fin_req=='No'){
                                        echo '-';
                                    }else{
                                        echo $stages->stage_name;
                                    }
                                    ?>
                                </td>

                                <td><?php $user_name=User::find($value->updated_by); echo $user_name->employee_name;?></td>
                                <td><?=date('d-m-Y h:i:s A',strtotime($value->updated_at))?></td>
                            </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>
                </div>


            </div>
        </div>
    </div>
<!--Exchange History    -->

    <div class="invoice-content">
        <div class="col-xl-12">
            <div class="panel panel-inverse" data-sortable-id="form-validation-1">
                <div class="panel-heading">
                    <h4 class="panel-title">Exchange History</h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                </div>

                <div class="panel-body">
                    <table class="table table-responsive">
                        <thead>
                        <tr>
                            <th width="1%">SN</th>
                            <th class="text-nowrap">Allotment Date</th>
                            <th class="text-nowrap">Customer Name</th>
                            <th class="text-nowrap">Exchange</th>
                            <th class="text-nowrap">Exchange Status</th>
                            <th class="text-nowrap">Exchange Remarks</th>
                            <th class="text-nowrap">Updated By</th>
                            <th class="text-nowrap">Updated At</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php
                        $alt_history=ExchangeHistory::select('*','vehicle_id="'.$get_vehicle_id.'"','id DESC');
                        foreach ($alt_history as $key=>$value):
                            ?>

                            <tr class="odd gradeX">
                                <td width="1%" class="f-w-600 text-inverse"><?=$key+1?></td>
                                <td><?=$value->allotment_dt?></td>
                                <td><?=$value->customer_name?></td>
                                <td><?=$value->is_exchange?></td>
                                <td><?php $ex_status=ExchangeStatus::find($value->exch_status); echo $ex_status->status_desc;?></td>
                                <td><?=$value->exch_remark?></td>
                                <td><?php $user_name=User::find($value->updated_by); echo $user_name->employee_name;?></td>
                                <td><?=$value->updated_at?></td>
                            </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>
                </div>


            </div>
        </div>
    </div>

<?php include 'includes/footer.php';?><?php
