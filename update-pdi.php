<?php
$page_title='Vehicle Inward';
$pdi_class='active';
include 'includes/header.php';
if (!$session->is_signed_in()) {redirect("login.php");}
include 'includes/top_nav.php';
include 'includes/sidebar.php';

if (empty($_GET['id'])){
    redirect('pdi.php');
}

$pdi=Stock::find($_GET['id']);
$get_vehicle_id=$_GET['id'];
$variant=Variant::find_variant($pdi->model_code);
$pdi_history=new PDI_History();
if (isset($_POST['submit']))
{
    $pdi->veh_status=$_POST['stock_status'];
    $pdi->stock_location=$_POST['stock_location'];

    $pdi->save();

    $pdi_history->vehicle_id=$get_vehicle_id;
    $pdi_history->user_name=$session->user_id;
    $pdi_history->stock_loc_id=$_POST['stock_location'];
    $pdi_history->stock_status=$_POST['stock_status'];

    date_default_timezone_set('Asia/Kolkata');
    $date= date('Y-m-d');
    $time= date('H:i:s');
    $pdi_history->updated_at=$date.' '.$time;





    $pdi_history->save();
    redirect("pdi.php");
    $session->message(" Vehicle with {$pdi->chassis_no} and {$pdi->engine_no} inwarded successfully.");
}




?>
    <div id="content" class="content">
        <ol class="breadcrumb float-xl-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="pdi.php">Pre-Delivery Inspection</a></li>
            <li class="breadcrumb-item active"><?=$page_title?></li>
        </ol>


        <h1 class="page-header"><?=$page_title?></h1>

        <div class="invoice">

            <div class="invoice-company">
                Seva Automotive (Dealer Code: <?=$pdi->delr?>)
            </div>


            <div class="invoice-header">
                <div class="invoice-from">
                    <small>Transporter Details</small>
                    <address class="m-t-10 m-b-10">
                        <strong class="text-inverse">Transporter Name: <?=$pdi->trans_name?></strong><br />
                        Transport Reg #: <?=$pdi->transport_reg_number?><br />
                        Sent By: <?=$pdi->sent_by?><br />
                        Email ID: <?=$pdi->email_id?><br />
                    </address>
                </div>
                <div class="invoice-date">
                    <small>Invoice Details</small>
                    <div class="date text-inverse m-t-5"><?=date('d-m-Y',strtotime($pdi->invoice_dt))?></div>
                    <div class="invoice-detail">
                        Indent #: <?=$pdi->indent_allot_no?><br />
                    </div>
                </div>
            </div>
           <div class="invoice-content">
                <div class="table-responsive">
                    <table class="table table-invoice">
                        <thead>
                        <tr>
                            <th>Variant Name</th>
                            <th class="text-center" width="20%">Color</th>
                            <th class="text-center" width="10%">Chassis #</th>
                            <th class="text-right" width="20%">Engine #</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <span class="text-inverse"><?=$variant->variant_name?></span><br />
                                <small><?=$pdi->model_code?></small>
                            </td>
                            <td class="text-center"><?=$pdi->color?></td>
                            <td class="text-center"><?=$pdi->chassis_prefix.$pdi->chassis_no?></td>
                            <td class="text-right"><?=$pdi->engine_no?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <form action="" method="post" class="form-horizontal">
                    <div class="col-md-6">
                        <div class="form-group row m-b-15">
                            <label class="col-md-4 col-sm-4 col-form-label" for="stock_location">Stock Location * :</label>
                            <div class="col-md-8 col-sm-8">
                                <select name="stock_location" id="" class="form-control" data-parsley-required="true">
                                    <option value="">-Select Stock Location-</option>
                                    <?php
                                    $stock_loc=StockLocation::all();
                                    foreach ($stock_loc as $list) {
                                        if ($pdi->stock_location==$list->id){
                                            echo "<option selected value='".$list->id."'>";
                                        }else{
                                            echo "</option> <option value='".$list->id."'>";
                                        }
                                        echo $list->stock_loc_name."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row m-b-15">
                            <label class="col-md-4 col-sm-4 col-form-label" for="stock_status">Vehicle Status * :</label>
                            <div class="col-md-8 col-sm-8">
                                <select name="stock_status" id="" class="form-control" data-parsley-required="true">
                                    <?php
                                    $stock_status=array('Ok','Not Ok');
                                    foreach ($stock_status as $list) {
                                        if ($pdi->veh_status==strtolower($list)){
                                            echo "<option selected value='".strtolower($list)."'>";
                                        }else{
                                            echo "</option> <option value='".strtolower($list)."'>";
                                        }
                                        echo $list."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row m-b-0">
                        <label class="col-md-4 col-sm-4 col-form-label">&nbsp;</label>
                        <div class="col-md-8 col-sm-8">
                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php include 'includes/footer.php';?><?php
