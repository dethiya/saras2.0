<?php 
    $page_title='Group Indent Transactions';
    $branch_class='active';
    $grp_class='active';
    include 'includes/header.php';
    if (!$session->is_signed_in()) {redirect("login.php");}
    include 'includes/top_nav.php';
    include 'includes/sidebar.php';
if (isset($_GET['type']) && $_GET['type']!=''){
    $type=$_GET['type'];
    $id=$_GET['id'];
    $update_status=Indent::find($_GET['id']);
    $update_status->is_approved=$type;
    $update_status->approved_by=$session_user->id;
    date_default_timezone_set('Asia/Kolkata');
    $date= date('Y-m-d');
    $time= date('H:i:s');
    $update_status->approval_datetime=$date.' '.$time;
    $update_status->save();
    redirect('update-allotment.php?id='.$update_status->vehicle_id);
    $session->message='Indent request accepted.';
}


        $allotment=Indent::select('*','','id desc');
    ?>
    <div id="content" class="content">
        <ol class="breadcrumb float-xl-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active"><?=$page_title?></li>
        </ol>


        <h1 class="page-header"><?=$page_title?></h1>
        <div class="row">
            <div class="col-xl-12">
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <h4 class="panel-title"><?=$page_title?></h4>

                        <div class="panel-heading-btn">
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                        </div>
                    </div>

                    <div class="panel-body">
                        <table id="data-table-combine" class="table table-striped table-bordered table-td-valign-middle">
                            <thead>
                            <tr>
                                <th width="1%">SN</th>
                                <th>Actions</th>
                                <th width="1%">BT Dispatch Status</th>
                                <th>Raised By</th>
                                <th width="1%">From Location</th>
                                <th width="1%">To Location</th>
                                <th>Indent Date/Time</th>
                                <th>Acceptance Date/Time</th>
                                <th>Accepted By</th>
                                <th>Variant Name</th>
                                <th>Color</th>
                                <th>Chassis #</th>
                                <th>Engine #</th>
                                <th>Veh. Purchase Dt.</th>
                                <th>Current Location</th>

                                <th width="1%">BT Dispatch Dt</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($allotment as $key=>$value):
                                    $get_vehicle_details=Stock::find($value->vehicle_id);
                                    $get_maker=User::find($value->request_user_id);
                                    $get_checker=User::find($value->approved_by);
                                    ?>
                                <tr>
<!--                                    SR NO.-->
                                    <td><?=$key+1?></td>

                                    <td>
                                        <?php if ($value->is_approved==1): ?>
                                            <span href="" class="label label-theme bg-success"><i class="fa fa-check"></i>    Accepted</span>
                                        <?php else:?>
                                            <span href="" class="label label-theme bg-secondary"><i class="fa fa-exclamation"></i> Pending</span>
                                        <?php endif;?>
                                    </td>
                                    <td>
                                        <?php if ($value->dispatch==1){ ?>
                                            <span href="" class="label label-theme bg-warning "><i class="fa fa-sync fa-spin"></i> In Transit</span>
                                        <?php }elseif($value->dispatch==0){?>
                                            <span href="" class="label label-theme bg-secondary "><i class="fa fa-clock"></i> Awaited</span>
                                        <?php }else{ ?>
                                            <span href=""  class="label label-theme bg-success "><i class="fa fa-thumbs-up"></i> Delivered</span>
                                        <?php };?>
                                    </td>
                                    <td><?php echo $get_maker->employee_name;?></td>
                                    <td><?php
                                        $outlets=Outlet::find_outlet($value->request_outlet_id); echo $outlets->outlet_name;
                                        ?></td>
                                    <td><?php
                                        $outlets=Outlet::find_outlet($value->existing_outlet_code); echo $outlets->outlet_name;
                                        ?></td>
                                    <td data-order="<?=$value->datetime?>"><?=date('d-m-Y h:i:s A',strtotime($value->datetime))?></td>

                                    <td date-order="<?=$value->approval_datetime?>">
                                        <?=$value->is_approved==0?'-':date('d-m-Y h:i:s A',strtotime($value->approval_datetime));?>

                                    </td>
                                    <td>
                                        <?php
                                        echo $value->approved_by>0?$get_checker->employee_name:'Acceptance Awaited';?></td>


                                    <td>
                                        <?php
                                        $get_variant=Variant::find_variant($get_vehicle_details->model_code);
                                        echo $get_variant->variant_name;
                                        ?>
                                    </td>
                                    <td><?php $get_color=Color::find_color($get_vehicle_details->color); echo $get_color->color_name;?></td>
                                    <td><?=$get_vehicle_details->chassis_no?></td>
                                    <td><?=$get_vehicle_details->engine_no?></td>
                                    <td data-order="<?=$get_vehicle_details->invoice_dt?>"><?=date('d-m-Y',strtotime($get_vehicle_details->invoice_dt))?></td>
                                    <td>
                                        <?php $get_stock_location=StockLocation::find($get_vehicle_details->stock_location);
                                        echo $get_stock_location->stock_loc_name; ?>
                                    </td>


                                    <td data-order="<?=$value->dispatch_date?>">
                                        <?=$value->dispatch==0?'-':date('d-m-Y H:i:s A',strtotime($value->dispatch_date));?>
                                    </td>
                                </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php include 'includes/delete_modal.php';?>
<?php include 'includes/footer.php';?>
