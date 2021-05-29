<?php 
    $page_title='Indents';
$branch_class='active';
$indent_class='active';
    include 'includes/header.php';
    if (!$session->is_signed_in()) {redirect("login.php");}
    include 'includes/top_nav.php';
    include 'includes/sidebar.php';


        $allotment=Indent::select('*','request_outlet_id="'.$session_user->outlet_id.'"');
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
                <a href="#" class="alert-link"></a>.
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
                                <th>Indent Status</th>
                                <th width="1%">Indent Raised To</th>
                                <th>Indent Date</th>
                                <th class="text-nowrap">Variant Name</th>
                                <th class="text-nowrap">Color</th>
                                <th class="text-nowrap">Chassis #</th>
                                <th class="text-nowrap">Engine #</th>
                                <th class="text-nowrap">Dispatch Date</th>
                                <th class="text-nowrap">Current Location</th>
                                <th width="1%">Acceptance Date/Time</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($allotment as $key=>$value):
                                    $get_vehicle_details=Stock::find($value->vehicle_id);
//                                echo '<pre>'; print_r($get_vehicle_details);
                                    ?>
                                <tr>
                                    <td><?=$key+1?></td>
                                    <td class="text-center">
                                        <?php if ($value->is_approved==1): ?>
                                            <a href="" class="btn btn-success btn-icon btn-sm"><i class="fa fa-check"></i></a>
                                        <?php else:?>
                                            <a href="" class="btn btn-danger btn-icon btn-sm"><i class="fas fa-exclamation-triangle"></i></a>
                                        <?php endif;?>
                                    </td>
                                    <td><?=$value->existing_outlet_code?></td>
                                    <td><?=date('d-m-Y H:m:s A',strtotime($value->datetime))?></td>

                                    <td>
                                        <?php
                                            $get_variant=Variant::find_variant($get_vehicle_details->model_code);
                                            echo $get_variant->variant_name;
                                            ?>
                                    </td>

                                    <td>
                                        <?php
                                            $get_color=Color::find_color($get_vehicle_details->color);
                                            echo $get_color->color_name;
                                            ?>
                                    </td>
                                    <td><?=$get_vehicle_details->chassis_no?></td>
                                    <td><?=$get_vehicle_details->engine_no?></td>
                                    <td><?=date('d-m-Y',strtotime($get_vehicle_details->invoice_dt))?></td>
                                    <td>
                                        <?php $get_stock_location=StockLocation::find($get_vehicle_details->stock_location);
                                        echo $get_stock_location->stock_loc_name; ?>
                                    </td>

                                    <td>
                                    <?=$value->is_approved==0?'-':date('d-m-Y H:i:s A',strtotime($value->approval_datetime));?>
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
