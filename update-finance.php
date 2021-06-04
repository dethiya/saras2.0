<?php
$page_title='Finance Status Update';
$finance_class='active';
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

if ($allotment->fin_is_fin_req=='Yes') {
        $disabled='';
} else {
    $disabled='disabled';
}


$history=new FinanceHistory();
if (isset($_POST['submit']))
{
    date_default_timezone_set('Asia/Kolkata');
    $allotment->fin_is_fin_req=$_POST['fin_is_fin_req'];
    $allotment->mssf_id=$_POST['mssf_id'];
    $allotment->mssf_login_dt=$_POST['mssf_login_dt'];
    $allotment->fin_is_fin_req=='No'?$allotment->fin_fin_type="Nil":$allotment->fin_fin_type=$_POST['fin_fin_type'];
    $allotment->fin_bank_id=$_POST['fin_bank_id'];
    $allotment->branch=$_POST['branch'];
    $allotment->bank_executive=$_POST['bank_executive'];
    $allotment->fin_stage=$_POST['fin_stage'];
    $allotment->fin_stage_dt=date('Y-m-d');
    $allotment->remark_one=$_POST['remark_one'];
    $allotment->customer_mobile_no=$_POST['customer_mobile_no'];
    $allotment->save();

    $history->vehicle_id        = $get_vehicle_id;
    $history->allotment_dt      = $allotment->allotment_dt;
    $history->customer_name     = $allotment->customer_name;
    $history->fin_is_fin_req    = $allotment->fin_is_fin_req;
    $history->mssf_id           = $allotment->mssf_id;
    $history->mssf_login_dt      = $allotment->mssf_login_dt;
    $history->fin_fin_type      = $allotment->fin_fin_type;
    $history->fin_bank_id       = $allotment->fin_bank_id;
    $history->branch            = $allotment->branch;
    $history->bank_executive    = $allotment->bank_executive;
    $history->fin_stage         = $allotment->fin_stage;
    $history->fin_stage_dt      = $allotment->fin_stage_dt;
    $history->remark_one        = $allotment->remark_one;
    $history->customer_mobile_no    = $allotment->customer_mobile_no;
    $history->updated_by        = $session->user_id;


    $date= date('Y-m-d');
    $time= date('H:i:s');
    $history->updated_at        = $date.' '.$time;

    $history->save();
    redirect("finance.php");
    $session->message(" Finance details for vehicle with Chassis No. {$allotment->chassis_no} and Engine No. {$allotment->engine_no} updated successfully.");
}




?>
    <div id="content" class="content">
        <ol class="breadcrumb float-xl-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="allotment.php">Allotment</a></li>
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
                            <h4 class="panel-title">Update Finance Status</h4>
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
                                    <label class="col-md-4 col-sm-4 col-form-label" for="fin_is_fin_req">
                                        Is Finance Required? * :
                                    </label>
                                    <div class="col-md-4 col-sm-4">
                                        <select name="fin_is_fin_req" id="is_finance" class="form-control" data-parsley-required="true" autofocus>
                                            <option value="">-Select Finance-</option>
                                            <?php
                                            $fin_req=array('Yes','No');
                                            foreach ($fin_req as $list) {
                                                if ($allotment->fin_is_fin_req==$list):?>
                                                    <option selected value="<?=$list?>">
                                                <?php else:?>
                                                    </option> <option value="<?=$list?>">
                                                <?php endif;?>
                                                <?=$list?></option>

                                            <?php } ?>

                                        </select>
                                    </div>
                                </div>
<!-- MSSF ID -->
                                <div class="form-group row m-b-15 ">
                                    <label class="col-md-4 col-sm-4 col-form-label" for="mssf_id">
                                        MSSF ID :
                                    </label>
                                    <div class="col-md-4 col-sm-4">
                                        <input class="form-control" type="text" value="<?=$allotment->mssf_id?>" id="mssf_id" name="mssf_id" placeholder="Enter MSSF ID" <?=$disabled?> />
                                        
                                    </div>
                                </div>
<!-- MSSF Login Date -->
                                <div class="form-group row m-b-15 ">
                                    <label class="col-md-4 col-sm-4 col-form-label" for="mssf_login_dt">
                                        MSSF Login Date :
                                    </label>
                                    <div class="col-md-4 col-sm-4">
                                        <input class="form-control" type="date" value="<?=$allotment->mssf_login_dt?>" id="mssf_login_dt" name="mssf_login_dt" placeholder="Enter Remarks" <?=$disabled?> />
                                    </div>
                                </div>


                                <div class="form-group row m-b-15 ">
                                    <label class="col-md-4 col-sm-4 col-form-label" for="fin_fin_type">Finance Type :</label>
                                    <div class="col-md-4 col-sm-4">
                                        <select name="fin_fin_type" id="finance_type" class="form-control" <?=$disabled?>>
                                            <option value="">-Select Finance Type-</option>
                                            <?php
                                            $fin_type=array('Self Finance', 'SAPL Finance','Bank Staff');
                                            foreach ($fin_type as $list) {
                                                if ($allotment->fin_fin_type==$list){
                                                    echo "<option selected value='".$list."'>";
                                                }else{
                                                    echo "</option> <option value='".$list."'>";
                                                }
                                                echo $list."</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row m-b-15">
                                    <label class="col-md-4 col-sm-4 col-form-label " for="fin_bank_id">Bank :</label>
                                    <div class="col-md-4 col-sm-4">
                                        <select name="fin_bank_id" id="fin_bank_id" class="form-control" <?=$disabled?> >
                                            <option value="">-Select Bank-</option>
                                            <?php
                                            $banks=Bank::select('*','','bank_name asc');
                                            foreach ($banks as $list) {
                                                if ($allotment->fin_bank_id==$list->id){
                                                    echo "<option selected value='".$list->id."'>";
                                                }else{
                                                    echo "</option> <option value='".$list->id."'>";
                                                }
                                                echo $list->bank_name.'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
<!-- Branch -->
                                <div class="form-group row m-b-15  ">
                                    <label class="col-md-4 col-sm-4 col-form-label" for="branch">
                                        Bank Branch :
                                    </label>
                                    <div class="col-md-4 col-sm-4">
                                        <input class="form-control" type="text" value="<?=$allotment->branch?>" id="branch" name="branch" placeholder="Enter Branch" <?=$disabled?> />
                                    </div>
                                </div>
<!-- Bank Executive -->
                                <div class="form-group row m-b-15 ">
                                    <label class="col-md-4 col-sm-4 col-form-label" for="bank_executive">
                                        Bank Executive :
                                    </label>
                                    <div class="col-md-4 col-sm-4">
                                        <input class="form-control" type="text" value="<?=$allotment->bank_executive?>" id="bank_executive" name="bank_executive" placeholder="Enter Bank Executive Name" <?=$disabled?> />
                                    </div>
                                </div>
                                <div class="form-group row m-b-15   ">
                                    <label class="col-md-4 col-sm-4 col-form-label" for="fin_stage">
                                        Stage * :
                                    </label>
                                    <div class="col-md-4 col-sm-4">
                                    <select name="fin_stage" id="stages" class="form-control" >
                                    <option value="">-Select Finance Stage-</option>
                                            <?php
                                            $stages=FinStage::all();
                                            foreach ($stages as $list) {
                                                if ($allotment->fin_stage==$list->id){
                                                    echo "<option selected value='".$list->id."'>";
                                                }else{
                                                    echo "</option> <option value='".$list->id."'>";
                                                }
                                                echo $list->stage_name.'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
<!--Fixed Items-->
                                <div class="form-group row m-b-15 ">
                                    <label class="col-md-4 col-sm-4 col-form-label" for="fin_stage_dt">
                                        Finance Status Date * :
                                    </label>
                                    <div class="col-md-4 col-sm-4">
                                        <input class="form-control" type="date" value="<?=date('Y-m-d')?>" id="fin_stage_dt" name="" placeholder=""  readonly/>
                                    </div>
                                </div>



                                <div class="form-group row m-b-15 ">
                                    <label class="col-md-4 col-sm-4 col-form-label" for="remark_one">
                                        Remarks (if any) :
                                    </label>
                                    <div class="col-md-4 col-sm-4">
                                        <input class="form-control" type="text" value="<?=$allotment->remark_one?>" id="remark_one" name="remark_one" placeholder="Enter Remarks"  />
                                    </div>
                                </div>
                                <!-- Customer Mobile Number -->
                                <div class="form-group row m-b-15 ">
                                    <label class="col-md-4 col-sm-4 col-form-label" for="customer_mobile_no">
                                        Customer Mobile Number :
                                    </label>
                                    <div class="col-md-4 col-sm-4">
                                        <input class="form-control" type="number" value="<?=$allotment->customer_mobile_no?>" id="customer_mobile_no" name="customer_mobile_no" placeholder="Enter Customer Mobile Number"  />
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
