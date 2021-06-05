<?php 
    $page_title='Pre-Delivery Inspection';
    $pdi_class='active';
    include 'includes/header.php';
    if (!$session->is_signed_in()) {redirect("login.php");}
    include 'includes/top_nav.php';
    include 'includes/sidebar.php';




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
                    <form action="" method="POST">
                    <div  class="panel-body">
                        <table id="data-table-combine" class="table table-striped table-bordered table-td-valign-middle">
                            <thead>
                            <tr>
                                <th width="1%">SN</th>
                                <th width="1%">Delr Code</th>
                                <th class="text-nowrap">Dispatch Date</th>
                                <th class="text-nowrap">Transport Reg #</th>
                                <th class="text-nowrap">Variant Name</th>
                                <th class="text-nowrap">Variant Code</th>
                                <th class="text-nowrap">Color</th>
                                <th class="text-nowrap">Chassis Prefix</th>
                                <th class="text-nowrap">Chassis #</th>
                                <th class="text-nowrap">Engine #</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if ($session_user->role=='administrator') {
                                        $pdi=Stock::select('*','stock_location in (1,10)','invoice_dt, transport_reg_number asc');    
                                    } else {
                                        if ($session_user->outlet_id=="6801") {
                                            $pdi=Stock::select('*','delr in ("6801","68NA","68CA") and stock_location in (1,10)','invoice_dt, transport_reg_number asc');
                                           } elseif($session_user->outlet_id=="2002") {
                                            $pdi=Stock::select('*','delr in ("2002","20NB","20CC") and stock_location in (1,10)','invoice_dt, transport_reg_number asc');
                                           } elseif($session_user->outlet_id=="3701") {
                                            $pdi=Stock::select('*','delr in ("3701","37NA","37CB") and stock_location in (1,10)','invoice_dt, transport_reg_number asc');
                                           }else {
                                            $pdi=Stock::select('*','delr in ("P301","P3NA","P3CA") and stock_location in (1,10)','invoice_dt, transport_reg_number asc');
                                           } 
                                    }
                                    
                                   
                                   
                                    foreach ($pdi as $key=>$value):
                                ?>
                                <tr>
                                    <td><?=$key+1?></td>
                                    <td><?=$value->delr?></td>
                                    <td data-order=<?=$value->invoice_dt?>><?=date('d-m-Y',strtotime($value->invoice_dt))?></td>
                                    <td><?=$value->transport_reg_number?></td>
                                    <td>
                                        <?php
                                        $get_variant=Variant::find_variant($value->model_code);
                                        echo $get_variant->variant_name;
                                        ?>
                                    </td>
                                    <td><?=$value->model_code?></td>
                                    <td>
                                        <?php
                                        echo $value->color;
                                        ?>
                                    </td>
                                    <td><?=$value->chassis_prefix?></td>
                                    <td><?=$value->chassis_no?></td>
                                    <td><?=$value->engine_no?></td>
                                    <td>
                                        <a href="update-pdi.php?id=<?=$value->id?>">Update</a>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php include 'includes/footer.php';?>
