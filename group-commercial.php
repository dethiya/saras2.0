<?php 
    $page_title='Commercial Group Stock';
    $commercial_class='active';
    $group_class='active';
    include 'includes/header.php';
    if (!$session->is_signed_in()) {redirect("login.php");}
    include 'includes/top_nav.php';
    include 'includes/sidebar.php';

        $allotment=Stock::select('*','allot_status_id<>5 and delr in ("20CC","37NB","68CA","P3CA")','allot_status_id ASC, model_code ASC, color ASC, invoice_dt DESC');

    ?>
    <div id="content" class="content">
        <ol class="breadcrumb float-xl-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active"><?=$page_title?></li>
        </ol>

        <?php if ($session->message): ?>
            <div class="alert alert-success fade show">
                <span class="close" data-dismiss="alert">×</span>
                <strong>Success!</strong>
                <?=$session->message?>
                <a href="#" class="alert-link"></a>
            </div>
        <?php endif; ?>

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
                                <th>Status</th>
                                <th width="1%">Delr Code</th>
                                <th class="text-nowrap">Variant Name</th>
                                <th class="text-nowrap">Variant Code</th>
                                <th class="text-nowrap">Color</th>
                                <th class="text-nowrap">Color Code</th>
                                <th class="text-nowrap">Chassis Prefix</th>
                                <th class="text-nowrap">Chassis #</th>
                                <th class="text-nowrap">Engine #</th>
                                <th class="text-nowrap">Dispatch Date</th>
                                <th class="text-nowrap">Vintage</th>
                                <th class="text-nowrap">Year</th>
                                <th class="text-nowrap">Location</th>
                                <th class="text-nowrap">Customer Name</th>
                                <th class="text-nowrap">SRM</th>
                                <th class="text-nowrap">RM</th>
                                <th class="text-nowrap">Allotment Date</th>
                                <th class="text-nowrap">Allotment Days</th>
                                <th class="text-nowrap">SMS No</th>
                                <th class="text-nowrap">SMS Inv Dt</th>
                                <th class="text-nowrap">DMS No</th>
                                <th class="text-nowrap">DMS Inv Dt</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($allotment as $key=>$value):
                                    $get_srm=Srm::find($value->srm_id);
                                    $get_rm=Rm::find($value->rm_id);
                                    ?>
                                <tr>
                                    <td><?=$key+1?></td>
                                    <td><?php
                                        $get_allot_status=AllotStatus::find($value->allot_status_id);
                                        if ($get_allot_status->id==1){
                                            echo '<span class="label label-theme bg-gradient-gray">FPR</span>';
                                        }elseif ($get_allot_status->id==2){
                                            echo '<span class="label label-theme bg-danger">Allot</span>';
                                        }elseif ($get_allot_status->id==3){
                                            echo '<span class="label label-theme bg-warning">BT</span>';
                                        }else{
                                            echo '<span class="label label-theme">Free</span>';
                                        }
                                        ?></td>
                                    <td><?=$value->delr?></td>
                                    <td><?php $get_variant=Variant::find_variant($value->model_code); echo $get_variant->variant_name;?></td>
                                    <td><?=$value->model_code?></td>
                                    <td><?php $get_color=Color::find_color($value->color); echo $get_color->color_name;?></td>
                                    <td><?=$value->color?></td>
                                    <td><?=$value->chassis_prefix?></td>
                                    <td><?=$value->chassis_no?></td>
                                    <td><?=$value->engine_no?></td>
                                    <td><?=date('d-m-Y',strtotime($value->invoice_dt))?></td>
                                    <td>
                                    <?php
                                        $MSIL_dispatch_date = new DateTime(date('d-m-Y',strtotime($value->invoice_dt)));
                                        $current_date = new DateTime();
                                        echo $vintage = $current_date->diff($MSIL_dispatch_date)->format("%a");
                                        ?>
                                    </td>
                                    <td><?php $check_date=strtotime('31-12-2020');
                                        echo date('d-m-Y',strtotime($value->invoice_dt))>$check_date ? 'Type I' : 'Type II';
                                    ?></td>
                                    <td><a href="javascript:void(0)">
                                            <?php
                                                $get_stock_location=StockLocation::find($value->stock_location);
                                                if($get_stock_location){

                                                    echo $get_stock_location->stock_loc_name;
                                                }else{
                                                    echo 'Location not available';
                                                }

                                                ?>
                                        </a>
                                    </td>
                                    <td><?php echo empty($value->customer_name) ? '-' : $value->customer_name;?></td>
                                    <td><?php echo $value->srm_id>0 ? $get_srm->srm_name : '-'; ?></td>
                                    <td><?php echo $value->rm_id>0 ? $get_rm->rm_name : '-'; ?>
                                    </td>
                                    <td><?php echo !empty($value->customer_name) ? date('d-m-Y',strtotime($value->allotment_dt)) : '-'; ?></td>
                                    <td><?php
                                        if (!empty($value->customer_name)){
                                        $Alt_dt=new DateTime($value->allotment_dt);
                                        $allot_dt=$current_date->diff($Alt_dt)->format("%a");
                                        echo $allot_dt;
                                        }else{
                                            echo '-';
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo empty($value->sms_inv_no)?'-':$value->sms_inv_no;?></td>
                                    <td><?php echo empty($value->sms_inv_no) ? '-' : date('d-m-Y',strtotime($value->sms_inv_dt)); ?></td>
                                    <td><?php echo empty($value->dms_inv_no)?'-':$value->dms_inv_no;?></td>
                                    <td><?php echo empty($value->dms_inv_no) ? '-' : date('d-m-Y',strtotime($value->dms_inv_dt)); ?></td>
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
