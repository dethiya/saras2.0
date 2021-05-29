<?php
$page_title='Exchange Status Update';
$exchange_class='active';
include 'includes/header.php';
if (!$session->is_signed_in()) {redirect("login.php");}
include 'includes/top_nav.php';
include 'includes/sidebar.php';

if (empty($_GET['id'])){
    redirect('allotment.php');
}

$allotment=Stock::find($_GET['id']);
$get_vehicle_id=$_GET['id'];
$variant=Variant::find_variant($allotment->model_code);
$bank=Bank::find($allotment->fin_bank_id);
$get_fin_stage=FinStage::find($allotment->fin_stage);
$get_stock_loc=StockLocation::find($allotment->stock_location);
$get_exch_status=ExchangeStatus::find($allotment->exch_status);
$get_color=Color::find_color($allotment->color);

if($allotment->is_exchange=='Yes'){
    $disp='';
}else{
    $disp='display_div';
}

$history=new ExchangeHistory();
if (isset($_POST['submit']))
{
    date_default_timezone_set('Asia/Kolkata');
    $allotment->is_exchange=$_POST['is_exchange'];
    $allotment->exch_status=$_POST['exch_status'];
    $allotment->exch_date=date('Y-m-d');
    $allotment->exch_remark=$_POST['exch_remark'];
    $allotment->save();

    $history->vehicle_id        = $get_vehicle_id;
    $history->allotment_dt      = $allotment->allotment_dt;
    $history->customer_name     = $allotment->customer_name;
    $history->is_exchange       = $allotment->is_exchange;
    $history->exch_status       = $allotment->exch_status;
    $history->exch_date         = $allotment->exch_date;
    $history->exch_remark       = $allotment->exch_remark;
    $history->updated_by        = $session->user_id;


    $date= date('Y-m-d');
    $time= date('H:i:s');
    $history->updated_at        = $date.' '.$time;

    $history->save();
    redirect("exchange.php");
    $session->message(" Exchange details for vehicle with Chassis No. {$allotment->chassis_no} and Engine No. {$allotment->engine_no} updated successfully.");
}




?>
    <div id="content" class="content">
        <ol class="breadcrumb float-xl-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="exchange.php">Exchange</a></li>
            <li class="breadcrumb-item active"><?=$page_title?></li>
        </ol>


        <h1 class="page-header"><?=$page_title?></h1>

        <div class="invoice">

            <div class="invoice-company">
                <span class="pull-right hidden-print">
                    <a href="allotment-history.php?id=<?=$allotment->id?>" class="btn btn-sm btn-white m-b-10">
                        <i class="fa fa-file-alt t-plus-1 text-danger fa-fw fa-lg"></i> History</a>
                </span>
                Variant &amp; Color: <?=$variant->variant_name.' ('.$allotment->model_code.') / '.$get_color->color_name.' ('.$allotment->color.')';?> <small>Current Location: <?=$get_stock_loc->stock_loc_name?></small>
                <br>
                VIN: <?=$allotment->chassis_prefix.$allotment->chassis_no?> /
                Engine No: <?=$allotment->engine_no?> <br />
            </div>


            <div class="invoice-header">
                <div class="invoice-from">
                    <address class="m-t-5 m-b-5">
                        <strong class="text-inverse">Vehicle Details<br /></strong>

                        Customer Name #: <?=!empty($allotment->customer_name)? $allotment->customer_name : 'Not Alloted'; ?> <br>
                        Allotment Dt: <?=!empty($allotment->customer_name)?date('d-m-Y', strtotime($allotment->allotment_dt)):'N/A'?> <br />
                        Dispatch Date: <?=date('d-m-Y',strtotime($allotment->invoice_dt))?><br />
                        SMS Invoice #: <?=!empty($allotment->sms_inv_no)? $allotment->sms_inv_no : 'Pending'; ?> <br>
                        SMS Date: <?=!empty($allotment->sms_inv_no)?date('d-m-Y', strtotime($allotment->sms_inv_dt)):'N/A'?> <br />

                    </address>
                </div>
                <div class="invoice-from">
                    <address class="m-t-5 m-b-5">
                        <strong class="text-inverse">Finance Details<br /></strong>
                        Finance Required: <?=empty($allotment->fin_is_fin_req)?'-':$allotment->fin_is_fin_req?><br />
                        Finance Type: <?=empty($allotment->fin_fin_type)?'-':$allotment->fin_fin_type?><br />
                        Finance Bank: <?= $allotment->fin_bank_id>0?$bank->bank_name:'-'?> <br>
                        Finance Stage: <?=$allotment->fin_stage?$get_fin_stage->stage_name:'-'?><br />
                        Last Stage Recorded Date: <?=!empty($allotment->fin_is_fin_req)?date('d-m-Y', strtotime($allotment->fin_stage_dt)):'-'?> <br />
                    </address>
                </div>
                <div class="invoice-from">

                    <address class="m-t-5 m-b-5">
                        <strong class="text-inverse">Exchange Details</strong><br />
                        Is Exchange: <?=empty($allotment->is_exchange)?'-':$allotment->is_exchange?><br />
                        Exchange Status: <?=empty($allotment->exch_status)?'-':$get_exch_status->status_desc?><br />
                        Last Status Update Date: <?=!empty($allotment->is_exchange)?date('d-m-Y', strtotime($allotment->exch_date)):'-'?> <br>
                    </address>
                </div>
            </div>


            <div class="invoice-content">

                <div class="col-xl-12">

                    <div class="panel panel-inverse" data-sortable-id="form-validation-1">

                        <div class="panel-heading">
                            <h4 class="panel-title">Update Exchange Status</h4>
                            <div class="panel-heading-btn">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                            </div>
                        </div>


                        <div class="panel-body">
                            <form class="form-horizontal" data-parsley-validate="true" enctype="multipart/form-data" method="post" action="">

                                <div class="form-group row m-b-15">
                                    <label class="col-md-4 col-sm-4 col-form-label" for="is_exchange">Is Exchange? * :</label>
                                    <div class="col-md-4 col-sm-4">
                                        <select name="is_exchange" id="is_exchange" class="form-control" data-parsley-required="true" autofocus>
                                            <option value="">-Select Exchange-</option>
                                            <?php
                                            $fin_req=array('Yes','No');
                                            foreach ($fin_req as $list) {
                                                if ($allotment->is_exchange==$list):?>
                                                    <option selected value="<?=$list?>">
                                                <?php else:?>
                                                    </option> <option value="<?=$list?>">
                                                <?php endif;?>
                                                <?=$list?></option>

                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group row m-b-15">
                                    <label class="col-md-4 col-sm-4 col-form-label <?=$disp?>" for="exch_status">Exchange Status * :</label>
                                    <div class="col-md-4 col-sm-4 <?=$disp?>" >
                                        <select name="exch_status" id="exch_status" onchange="getState(this.value)" class="form-control" >
                                            <option value="">-Select Exchange Status-</option>
                                            <?php
                                            $exchange_status=ExchangeStatus::all();
                                            foreach ($exchange_status as $list) {
                                                if ($allotment->exch_status==$list->id){
                                                    echo "<option selected value='".$list->id."'>";
                                                }else{
                                                    echo "</option> <option value='".$list->id."'>";
                                                }
                                                echo $list->status_desc.'</option>';

                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row m-b-15">
                                    <label class="col-md-4 col-sm-4 col-form-label" for="exch_date">Exchange Status Date * :</label>
                                    <div class="col-md-4 col-sm-4">
                                        <input class="form-control" type="date" value="<?=date('Y-m-d')?>" id="exch_date" name="" disabled placeholder="Required" data-parsley-required="true" />
                                    </div>
                                </div>



                                <div class="form-group row m-b-15">
                                    <label class="col-md-4 col-sm-4 col-form-label" for="exch_remark">Remarks (if any) :</label>
                                    <div class="col-md-4 col-sm-4">
                                        <input class="form-control" type="text" value="<?=$allotment->exch_remark?>" id="exch_remark" name="exch_remark" placeholder="Enter Remarks"  />
                                    </div>
                                </div>

                                <div class="form-group row m-b-0">
                                    <label class="col-md-4 col-sm-4 col-form-label">&nbsp;</label>
                                    <div class="col-md-4 col-sm-4">
                                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>

            </div>




        </div>
    </div>

<?php include 'includes/footer.php';?><?php
