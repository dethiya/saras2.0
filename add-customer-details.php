<?php
$page_title='Update Customer';
$pagename=basename($_SERVER['PHP_SELF']);
if($pagename=='add-customer-details.php')
{
    $del_reg_class='active';
    $delivery_menu_class='active';
}else {
    $del_reg_class='';
    $delivery_menu_class='';
}
include 'includes/header.php';
if (!$session->is_signed_in()) {redirect("login.php");}
include 'includes/top_nav.php';
include 'includes/sidebar.php';

if (empty($_GET['id'])){
    redirect('delivery-register.php');
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


$del_db=new DeliveryDatabase();
if (isset($_POST['submit']))
{
    $del_db->vehicle_id=$get_vehicle_id;
    $del_db->gatepass= $_POST['gatepass'];
    $del_db->mobile_no=$_POST['mobile_no'];
    $del_db->date_of_birth=$_POST['date_of_birth'];
    $del_db->email_id=$_POST['email_id'];
    $del_db->address=$_POST['address'];
    $del_db->updated_by=$session->user_id;

    date_default_timezone_set('Asia/Kolkata');
    $date= date('Y-m-d');
    $time= date('H:i:s');
    $del_db->updated_at=$date.' '.$time;

    $del_db->save();
    redirect("delivery-register.php");
    $session->message(" Customer details added successfully.");
}

?>
    <div id="content" class="content">
        <ol class="breadcrumb float-xl-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="delivery-register.php">Delivery Register</a></li>
            <li class="breadcrumb-item active"><?=$page_title?></li>
        </ol>
        <h1 class="page-header"><?=$page_title?></h1>

        <div class="invoice">

            <div class="invoice-company text-danger">

<span class="pull-right hidden-print">
<a href="allotment-history.php?id=<?=$allotment->id?>" class="btn btn-sm btn-white m-b-10">
    <i class="fa fa-file-alt t-plus-1 text-danger fa-fw fa-lg"></i> History</a>
</span>
                Customer Name: <?=empty($allotment->customer_name)?'-':$allotment->customer_name?><br />

            </div>


            <div class="invoice-header">
                <div class="invoice-from">
                    <address class="m-t-5 m-b-5">
                        <strong class="text-inverse">Vehicle Details<br /></strong>
                        Variant: <?=$variant->variant_name.' ('.$allotment->model_code.')';?><br>
                        Color: <?=$get_color->color_name.' ('.$allotment->color.')';?><br>
                        VIN: <?=$allotment->chassis_prefix.$allotment->chassis_no?> /
                        Engine No: <?=$allotment->engine_no?> <br />
                        Delivery Date: <?=!empty($allotment->allot_status_id==5)?date('d-m-Y h:i:s A', strtotime($allotment->delivery_datetime)):'N/A'?> <br />


                    </address>
                </div>
                <div class="invoice-to">
                    <address class="m-t-5 m-b-5">
                        <strong class="text-inverse">Other Details<br /></strong>

                        SRM Name: <?=$allotment->srm_id>0?$get_srm->srm_name:'-'?><br />
                        RM Name: <?=$allotment->rm_id>0?$get_rm->rm_name:'-'?><br />
                        HP: <?=$allotment->fin_bank_id>0?$bank->bank_name:'-'?><br />
                    </address>
                </div>

                <div class="invoice-date">
                    <address class="m-t-5 m-b-5">
                        <strong class="text-inverse">Invoice Details<br /></strong>
                        SMS Invoice #: <?=!empty($allotment->sms_inv_no)? $allotment->sms_inv_no : 'Pending'; ?> <br>
                        SMS Date: <?=!empty($allotment->sms_inv_no)?date('d-m-Y', strtotime($allotment->sms_inv_dt)):'N/A'?> <br />
                        DMS Invoice #: <?=!empty($allotment->dms_inv_no)? $allotment->dms_inv_no : 'Pending'; ?> <br>
                        DMS Date: <?=!empty($allotment->dms_inv_no)?date('d-m-Y', strtotime($allotment->dms_inv_dt)):'N/A'?> <br />
                    </address>
                </div>

            </div>


            <div class="invoice-content">
                <div class="col-xl-12">
                    <div class="panel panel-inverse" data-sortable-id="form-validation-1">
                        <div class="panel-heading">
                            <h4 class="panel-title">Add Customer Details</h4>
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
                                    <label class="col-md-4 col-sm-4 col-form-label" for="gatepass">Gatepass No. * :</label>
                                    <div class="col-md-4 col-sm-4">
                                        <input class="form-control" type="text" value="" id="gatepass" name="gatepass" placeholder="Enter gatepass no." autofocus data-parsley-required="true" />
                                    </div>
                                </div>
                                <div class="form-group row m-b-15">
                                    <label class="col-md-4 col-sm-4 col-form-label" for="mobile_no">Mobile No. :</label>
                                    <div class="col-md-4 col-sm-4">
                                        <input class="form-control" type="number" value="" id="mobile_no" name="mobile_no" placeholder="Enter mobile number"  />
                                    </div>
                                </div>
                                <div class="form-group row m-b-15">
                                    <label class="col-md-4 col-sm-4 col-form-label" for="date_of_birth">Date of Birth. :</label>
                                    <div class="col-md-4 col-sm-4">
                                        <input class="form-control" type="date" value="" id="date_of_birth" name="date_of_birth" placeholder=""  />
                                    </div>
                                </div>
                                <div class="form-group row m-b-15">
                                    <label class="col-md-4 col-sm-4 col-form-label" for="email_id">Email Id :</label>
                                    <div class="col-md-4 col-sm-4">
                                        <input class="form-control" type="email" value="" id="email_id" name="email_id" placeholder="Enter email id."  />
                                    </div>
                                </div>
                                <div class="form-group row m-b-15">
                                    <label class="col-md-4 col-sm-4 col-form-label" for="address">Address :</label>
                                    <div class="col-md-4 col-sm-4">
                                        <textarea name="address" id="address" class="form-control" cols="30" rows="5"></textarea>
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
