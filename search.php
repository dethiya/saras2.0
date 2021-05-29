<?php 
    $page_title='Search';
    include 'includes/header.php';
    if (!$session->is_signed_in()) {redirect("login.php");}
    include 'includes/top_nav.php';
    include 'includes/sidebar.php';

if (empty($_GET['text_search'])){
    redirect('index.php');
}

        $allotment=Stock::get_results($_GET['text_search']);
    ?>
    <div id="content" class="content">
        <ol class="breadcrumb float-xl-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active"><?=$page_title?></li>
        </ol>

        <h1 class="page-header">Showing records for "   <?=$_GET['text_search']?>" keyword.</h1>
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
                                <th width="1%">Actions</th>
                                <th width="1%">Delr Code</th>
                                <th class="text-nowrap">Variant Name</th>
                                <th class="text-nowrap">Color</th>
                                <th class="text-nowrap">Chassis #</th>
                                <th class="text-nowrap">Engine #</th>
                                <th class="text-nowrap">Dispatch Date</th>
                                <th class="text-nowrap">Location</th>
                                <th class="text-nowrap">Customer Name</th>

                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($allotment as $key=>$value):
                                    $get_srm=Srm::find($value->srm_id);
                                    $get_rm=Rm::find($value->rm_id);
                                    $get_allot_status=AllotStatus::find($value->allot_status_id);
                                    if($value->allot_status_id==5){$class='bg-black-transparent-5 text-inverse';}else{$class='';}
                                    ?>
                                <tr class="<?=$class?>">
                                    <td><?=$key+1;?></td>
                                    <td>

                                        <a href="allotment-history.php?id=<?=$value->id?>" class="btn btn-danger btn-icon btn-circle btn-sm">
                                            <i class="fa fa-history"></i>
                                        </a>
                                        <?php
                                        if($value->delr!=$session_user->outlet_id) {
                                            if ($value->allot_status_id!=5){?>
                                                <button class="btn btn-success btn-icon btn-sm btn-circle btnRaiseIndent" vehicle_id="<?=$value->id?>" chassis_no="<?=$value->chassis_no?>"><i class="fa fa-eject"></i></button>

                                        <?php } }?>
                                    </td>
                                    <td><?=$value->delr?></td>
                                    <td><?php $get_variant=Variant::find_variant($value->model_code); echo $get_variant->variant_name;?></td>
                                    <td><?php $get_color=Color::find_color($value->color); echo $get_color->color_name;?></td>
                                    <td><?=$value->chassis_no?></td>
                                    <td><?=$value->engine_no?></td>
                                    <td><?=date('d-m-Y',strtotime($value->invoice_dt))?></td>
                                    <td>
                                        <?php $get_stock_location=StockLocation::find($value->stock_location);
                                        echo $get_stock_location->stock_loc_name; ?>
                                    </td>
                                    <td><?php echo empty($value->customer_name) ? '-' : $value->customer_name;?></td>


                                    <td><?php

                                        echo $get_allot_status->status;
                                        ?></td>

                                </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



<?php include 'includes/footer.php';?>
