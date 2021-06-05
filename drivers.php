<?php 
    $page_title='Drivers';
    $driver_class='active';
    include 'includes/header.php';
    if (!$session->is_signed_in()) {redirect("login.php");}
    if($session_user->role!='administrator'){redirect('index.php');}
    include 'includes/top_nav.php';
    include 'includes/sidebar.php';
    if (isset($_GET['type']) && $_GET['type']!=''){
        $type=$_GET['type'];
        $id=$_GET['id'];
        $update_status=Driver::find($_GET['id']);
        $update_status->status=$type;
        $update_status->save();
        redirect('drivers.php');
        $session->message='Driver status updated successfully.';
    }

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
                            <a href="create-driver.php" class="btn btn-xs  btn-primary"><i class="fa fa-plus"></i> Add Driver</a>
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
                                <th>Driver Photo</th>
                                <th class="text-nowrap">Driver Name</th>
                                <th class="text-nowrap">DL No</th>
                                <th class="text-nowrap">Issue Dt</th>
                                <th class="text-nowrap">Valid Till</th>
                                <th>DL Status</th>
                                <th class="text-nowrap">DL Scanned Copy</th>
                                <th class="text-nowrap">Driver Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php  $driver=Driver::all();
                                foreach ($driver as $key=>$value):
                                    $expiry=strtotime($value->dl_validity);
                                    $current_dt=strtotime(date('Y-m-d'));
                                    $diff=$expiry-$current_dt;
                                    $vintage=round($diff/86000);
                            ?>
                            <tr class="odd gradeX">
                                <td width="1%" class="f-w-600 text-inverse"><?=$key+1?></td>
                                <td class="with-img">
                                    <img src="<?=$value->image_path_and_placeholder();?>" class="img-rounded height-30" />
                                </td>
                                <td><?=ucwords($value->driver_name)?></td>
                                <td><?=strtoupper($value->dl_no)?></td>
                                <td data-order="<?=$value->dl_issue_dt?>"><?=date('d-M-y',strtotime($value->dl_issue_dt))?></td>
                                <td data-order="<?=$value->dl_validity?>"><?=date('d-M-y',strtotime($value->dl_validity))?></td>
                                <td>
                                        
                                <?php
                                    if ($expiry<$current_dt) {
                                        echo '<span class="label label-theme label-danger">Expired :'.$vintage.' Ago</span>';
                                    } elseif ($expiry==$current_dt) {
                                        echo '<span class="label label-theme label-warning">Expiring Today</span>';
                                    }else {
                                        echo '<span class="text-primary">'.$vintage.' Days To Expire</span>';                                    }
                                ?>
                                </td>
                                <td class="with-img">
                                    <a href="<?=$value->dl_path_and_placeholder();?>" target="_blank"><img src="<?=$value->dl_path_and_placeholder();?>" class="img-rounded height-30" /></a>
                                </td>
                                <td>
                                    <?php if ($value->status==1): ?>
                                        <a href="?type=0&id=<?=$value->id?>">Active</a>
                                    <?php else:?>
                                        <a href="?type=1&id=<?=$value->id?>">Inactive</a>
                                    <?php endif;?>
                                </td>
                                <td>
                                    <a href="edit-user.php?id=<?=$value->id?>" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                                    <a href="delete/delete_user.php?id=<?=$value->id?>" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
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

<?php include 'includes/footer.php';?><?php
