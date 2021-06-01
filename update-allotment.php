<?php
$page_title='Vehicle Allotment';
$allotment_class='active';
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


$history=new AllotHistory();
if (isset($_POST['submit']))
{
    date_default_timezone_set('Asia/Kolkata');
    $allotment->allot_status_id=$_POST['allot_status_id'];
    $allotment->allotment_dt=$_POST['allotment_dt'];
    $allotment->customer_name=ucwords(strtolower($_POST['customer_name']));
    $allotment->srm_id=$_POST['srm_id'];
    $allotment->rm_id=$_POST['rm_id'];
    $allotment->allotment_remark=$_POST['allotment_remark'];
    $allotment->mga_amount=$_POST['mga_amount'];
    $allotment->save();

    $history->vehicle_id=$get_vehicle_id;
    $history->allot_status_id=$allotment->allot_status_id;
    $history->allotment_dt=$allotment->allotment_dt;
    $history->customer_name= $allotment->customer_name;
    $history->srm_id=$allotment->srm_id;
    $history->rm_id=$allotment->rm_id;
    $history->allotment_remark=$allotment->allotment_remark;
    $history->updated_by=$session->user_id;


    $date= date('Y-m-d');
    $time= date('H:i:s');
    $history->updated_at=$date.' '.$time;

    $history->save();
    redirect("allotment.php");
    $session->message(" The allotment for the Vehicle with Chassis No. {$allotment->chassis_no} and Engine No. {$allotment->engine_no} updated successfully.");
}




?>
    <div id="content" class="content">
        <ol class="breadcrumb float-xl-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="allotment.php">Allotment</a></li>
            <li class="breadcrumb-item active"><?=$page_title?></li>
        </ol>
        <?php if ($session->message): ?>
            <div class="alert alert-success fade show">
                <span class="close" data-dismiss="alert">×</span>
                <strong>Success!</strong>
                <?=$session->message?>
                <a href="#" class="alert-link"></a>.
            </div>
        <?php endif; ?>

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

                        Dispatch Date: <?=date('d-m-Y',strtotime($allotment->invoice_dt))?><br />
                        SMS Invoice #: <?=!empty($allotment->sms_inv_no)? $allotment->sms_inv_no: 'Pending'; ?> <br>

                        SMS Date: <?=!empty($allotment->sms_inv_no)?date('d-m-Y', strtotime($allotment->sms_inv_dt)):'N/A'?> <br />

                        DMS Invoice #: <?=!empty($allotment->dms_inv_no)? $allotment->dms_inv_no : 'Pending'; ?> <br>

                        DMS Date: <?=!empty($allotment->dms_inv_no)?date('d-m-Y', strtotime($allotment->dms_inv_dt)):'N/A'?> <br />

                    </address>
                </div>
                <div class="invoice-from">
                    <address class="m-t-5 m-b-5">
                        <strong class="text-inverse">Finance Details<br /></strong>
                        Finance Required: <?=empty($allotment->fin_is_fin_req)?'-':$allotment->fin_is_fin_req?><br />
                        Finance Type: <?=empty($allotment->fin_fin_type)?'-':$allotment->fin_fin_type?><br />
                        Finance Bank: <?= empty($allotment->fin_bank_id)?'-':$bank->bank_name?> <br>
                        Finance Stage: <?=empty($allotment->fin_stage)?'-':$get_fin_stage->stage_name?><br />
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
                            <h4 class="panel-title">Update Allotment</h4>
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
                                    <label class="col-md-4 col-sm-4 col-form-label" for="allot_status_id">Allotment Status * :</label>
                                    <div class="col-md-4 col-sm-4">
                                        <select name="allot_status_id" id="" class="form-control" data-parsley-required="true" autofocus>
                                            <option value="">-Select Status-</option>
                                            <?php
                                            $allot_status=AllotStatus::select('*','id<>5 and id<>6');
                                            foreach ($allot_status as $list) {
                                                if ($allotment->allot_status_id==$list->id){
                                                    echo "<option selected value='".$list->id."'>";
                                                }else{
                                                    echo "</option> <option value='".$list->id."'>";
                                                }
                                                echo $list->status."</option>";

                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                
                                    
                                    <div class="form-group row m-b-15">
                                        <label class="col-md-4 col-sm-4 col-form-label" for="allotment_dt">Allotment Date * :</label>
                                        <div class="col-md-4 col-sm-4">
                                        <?php
                                        if($allotment->allot_status_id==4){
                                            echo '<input class="form-control " type="date" value="'.date('Y-m-d').'" id="allotment_dt" name="allotment_dt" placeholder="Required" data-parsley-required="true" readonly />';
                                        }else{
                                            echo '<input class="form-control " type="date" value="'.$allotment->allotment_dt.'" id="allotment_dt" name="allotment_dt" placeholder="Required" data-parsley-required="true" readonly />';
                                        }
                                    ?>
                                    
                                            
                                        </div>
                                    </div>
                                <div class="form-group row m-b-15">
                                    <label class="col-md-4 col-sm-4 col-form-label" for="customer_name">Customer Name * :</label>
                                    <div class="col-md-4 col-sm-4">
                                        <input class="form-control" type="text" value="<?=$allotment->customer_name?>" id="customer_name" name="customer_name" placeholder="Enter Customer Name" data-parsley-required="true" />
                                    </div>
                                </div>

                                <div class="form-group row m-b-15">
                                    <label class="col-md-4 col-sm-4 col-form-label" for="srm_id">SRM * :</label>
                                    <div class="col-md-4 col-sm-4">
                                        <select name="srm_id" id="" class="form-control" data-parsley-required="true" autofocus>
                                            <option value="">-Select SRM-</option>
                                            <?php
                                            $get_srm=Srm::select('*','status=1','srm_name asc');
                                            foreach ($get_srm as $list) {
                                                if ($allotment->srm_id==$list->id){
                                                    echo "<option selected value='".$list->id."'>";
                                                }else{
                                                    echo "</option> <option value='".$list->id."'>";
                                                }
                                                echo $list->srm_name."</option>";

                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row m-b-15">
                                    <label class="col-md-4 col-sm-4 col-form-label" for="rm_id">RM * :</label>
                                    <div class="col-md-4 col-sm-4">
                                        <select name="rm_id" id="" class="form-control" data-parsley-required="true" autofocus>
                                            <option value="">-Select RM-</option>
                                            <?php
                                            $get_rm=Rm::select('*','status=1','rm_name asc');
                                            foreach ($get_rm as $list) {
                                                if ($allotment->rm_id==$list->id){
                                                    echo "<option selected value='".$list->id."'>";
                                                }else{
                                                    echo "</option> <option value='".$list->id."'>";
                                                }
                                                echo $list->rm_name."</option>";

                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group row m-b-15">
                                    <label class="col-md-4 col-sm-4 col-form-label" for="allotment_remark">Allotment Remarks (if any) :</label>
                                    <div class="col-md-4 col-sm-4">
                                        <input class="form-control" type="text" value="<?=$allotment->allotment_remark?>" id="allotment_remark" name="allotment_remark" placeholder="Enter Remarks"  />
                                    </div>
                                </div>

                                <div class="form-group row m-b-15">
                                    <label class="col-md-4 col-sm-4 col-form-label" for="mga_amount">MGA Amount :</label>
                                    <div class="col-md-4 col-sm-4">
                                        <input class="form-control" type="text" value="<?=$allotment->mga_amount?>" id="mga_amount" name="mga_amount" placeholder="Enter MGA Amount"  />
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
