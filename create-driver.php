<?php
$page_title='Create Driver';
$driver_class='active';
include 'includes/header.php';
if (!$session->is_signed_in()) {redirect("login.php");}
include 'includes/top_nav.php';
include 'includes/sidebar.php';

$driver=new Driver();
if(isset($_POST['submit']))
{
    $driver->driver_name=trim($_POST['driver_name']);
    $driver->address=trim($_POST['address']);
    $driver->dl_no=trim($_POST['dl_no']);
    $driver->vehicle_class=trim($_POST['vehicle_class']);
    $driver->dl_issue_dt=trim($_POST['dl_issue_dt']);
    $driver->dl_validity=trim($_POST['dl_validity']);
    $driver->dob=trim($_POST['dob']);
    $driver->status=1;

    $driver->set_file($_FILES['user_image']);
    $driver->upload_photo();

    $driver->set_dl($_FILES['dl_scanned_copy']);
    $driver->upload_dl();

    $driver->save();
    redirect('drivers.php');
    $session->message("New Driver {$driver->driver_name} created successfully.");
    }
?>
    <div id="content" class="content">
        <ol class="breadcrumb float-xl-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="users.php">Users</a></li>
            <li class="breadcrumb-item active"><?=$page_title?></li>
        </ol>


<?php if ($message): ?>
    <div class="alert alert-danger fade show">
        <span class="close" data-dismiss="alert">×</span>
        <strong>Error!</strong>
        <?=$message?>
        <a href="#" class="alert-link"></a>.
    </div>
<?php endif; ?>
        <h1 class="page-header"><?=$page_title?></h1>
        <div class="row">
            <div class="col-xl-12">
                <div class="col-xl-6">

                    <div class="panel panel-inverse" data-sortable-id="form-validation-1">

                        <div class="panel-heading">
                            <h4 class="panel-title">Add Driver</h4>
                            <div class="panel-heading-btn">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                            </div>
                        </div>


                        <div class="panel-body">
                            <form class="form-horizontal" enctype="multipart/form-data" data-parsley-validate="true" method="post" action="">
                                <div class="form-group row m-b-15">
                                    <label class="col-md-4 col-sm-4 col-form-label" for="driver_name">Driver Name * :</label>
                                    <div class="col-md-8 col-sm-8">
                                        <input class="form-control" type="text" id="driver_name" name="driver_name" placeholder="Required" data-parsley-required="true" />
                                    </div>
                                </div>

                                <div class="form-group row m-b-15">
                                    <label class="col-md-4 col-sm-4 col-form-label" for="address">Address :</label>
                                    <div class="col-md-8 col-sm-8">
                                        <input class="form-control" type="text" id="address" name="address" placeholder="Required" />
                                    </div>
                                </div>

                                <div class="form-group row m-b-15">
                                    <label class="col-md-4 col-sm-4 col-form-label" for="user_image">Driver Image :</label>
                                    <div class="col-md-8 col-sm-8">
                                        <input class="" type="file" id="user_image" name="user_image"  accept="image/png, image/jpeg" />
                                        <div class="text-danger">Only png & jpg/jpeg files allowed.</div>
                                    </div>
                                    
                                </div>

                                <div class="form-group row m-b-15">
                                    <label class="col-md-4 col-sm-4 col-form-label" for="dl_no">Driving License :</label>
                                    <div class="col-md-8 col-sm-8">
                                        <input class="form-control" type="text" id="dl_no" name="dl_no" placeholder="Required" />
                                    </div>
                                </div>

                                <div class="form-group row m-b-15">
                                    <label class="col-md-4 col-sm-4 col-form-label" for="vehicle_class">Class of Vehicle * :</label>
                                    <div class="col-md-8 col-sm-8">
                                        <select name="vehicle_class" id="" class="form-control" data-parsley-required="true">
                                            <option value="">-Vehicle Class-</option>
                                            <?php
                                                $vehicle_class=array('LMV-NT-Car','LMV-TR','Others');
                                                foreach ($vehicle_class as $list)
                                                    echo "<option value='".strtolower($list)."'>$list</option>";
                                            ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row m-b-15">
                                    <label class="col-md-4 col-sm-4 col-form-label" for="dl_issue_dt">DL Issue Date * :</label>
                                    <div class="col-md-8 col-sm-8">
                                        <input class="form-control" type="date" id="dl_issue_dt" name="dl_issue_dt" placeholder="Required" data-parsley-required="true" />
                                    </div>
                                </div>

                                <div class="form-group row m-b-15">
                                    <label class="col-md-4 col-sm-4 col-form-label" for="dl_validity">DL Validity * :</label>
                                    <div class="col-md-8 col-sm-8">
                                        <input class="form-control" type="date" id="dl_validity" name="dl_validity" placeholder="Required" min="<?=date('Y-m-d')?>" data-parsley-required="true" />
                                    </div>
                                </div>

                                <div class="form-group row m-b-15">
                                    <label class="col-md-4 col-sm-4 col-form-label" for="dob">Date of Birth * :</label>
                                    <div class="col-md-8 col-sm-8">
                                        <input class="form-control" type="date" id="dob" name="dob" placeholder="Required" data-parsley-required="true" />
                                    </div>
                                </div>

                                <div class="form-group row m-b-15">
                                    <label class="col-md-4 col-sm-4 col-form-label" for="dl_scanned_copy">Upload Scanned DL :</label>
                                    <div class="col-md-8 col-sm-8">
                                        <input class="" type="file" id="dl_scanned_copy" name="dl_scanned_copy"  />
                                        <div class="text-danger">Only png, jpg/jpeg, pdf files allowed.</div>
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
    </div>

<?php include 'includes/footer.php';?><?php
