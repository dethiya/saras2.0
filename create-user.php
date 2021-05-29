<?php
$page_title='Create User';
$contact_class='active';
include 'includes/header.php';
if (!$session->is_signed_in()) {redirect("login.php");}
include 'includes/top_nav.php';
include 'includes/sidebar.php';

$user=new User();
if(isset($_POST['submit']))
{
    $user->employee_name=trim($_POST['employee_name']);
    $user->outlet_id=trim($_POST['outlet_id']);
    $user->role=trim($_POST['role']);
    $user->email_id=trim($_POST['email_id']);
    $user->username=trim($_POST['username']);
    $user->password=trim($_POST['password']);
    $user->status=1;

    $user->set_file($_FILES['user_image']);
    $user->upload_photo();

    $prevQuery = "SELECT id FROM users WHERE username = '".$user->username."'";
    $prevResult = $database->query($prevQuery);

    if($prevResult->num_rows > 0){
        $message="Employee with username {$user->username} already available in the portal";
    } else
    {
        $user->save();
        redirect('users.php');
        $session->message("New Employee {$user->employee_name} with username {$user->username} and id={$user->id} created successfully.");
    }
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
                            <h4 class="panel-title">New User</h4>
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
                                    <label class="col-md-4 col-sm-4 col-form-label" for="employee_name">Employee Name * :</label>
                                    <div class="col-md-8 col-sm-8">
                                        <input class="form-control" type="text" id="employee_name" name="employee_name" placeholder="Required" data-parsley-required="true" />
                                    </div>
                                </div>

                                <div class="form-group row m-b-15">
                                    <label class="col-md-4 col-sm-4 col-form-label" for="user_image">Profile Image :</label>
                                    <div class="col-md-8 col-sm-8">
                                        <input class="form-control" type="file" id="user_image" name="user_image"  />
                                    </div>
                                </div>


                                <div class="form-group row m-b-15">
                                    <label class="col-md-4 col-sm-4 col-form-label" for="outlet_id">Outlet * :</label>
                                    <div class="col-md-8 col-sm-8">
                                        <select name="outlet_id" id="" class="form-control" data-parsley-required="true">
                                            <option value="">-Select Outlet-</option>
                                            <?php $outlets=Outlet::all();
                                            foreach ($outlets as $outlet):?>
                                            <option value="<?=$outlet->outlet_code?>"><?=$outlet->outlet_name?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row m-b-15">
                                    <label class="col-md-4 col-sm-4 col-form-label" for="role">Role * :</label>
                                    <div class="col-md-8 col-sm-8">
                                        <select name="role" id="" class="form-control" data-parsley-required="true">
                                            <option value="">-Select Role-</option>
                                            <?php
                                                $user_role=array('Administrator','Customer Care','Exchange','Financer','PDI','Stock Manager');
                                                foreach ($user_role as $list)
                                                    echo "<option value='".strtolower($list)."'>$list</option>";
                                            ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row m-b-15">
                                    <label class="col-md-4 col-sm-4 col-form-label" for="email_id">Email Id * :</label>
                                    <div class="col-md-8 col-sm-8">
                                        <input class="form-control" type="email" id="email_id" name="email_id" placeholder="Required" data-parsley-required="true" />
                                    </div>
                                </div>

                                <div class="form-group row m-b-15">
                                    <label class="col-md-4 col-sm-4 col-form-label" for="username">Username * :</label>
                                    <div class="col-md-8 col-sm-8">
                                        <input class="form-control" type="text" id="username" name="username" placeholder="Required" data-parsley-required="true" />
                                    </div>
                                </div>

                                <div class="form-group row m-b-15">
                                    <label class="col-md-4 col-sm-4 col-form-label" for="password">Password * :</label>
                                    <div class="col-md-8 col-sm-8">
                                        <input class="form-control" type="password" id="password" name="password" placeholder="Required" data-parsley-required="true" />
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
