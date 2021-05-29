<?php
$page_title='Edit Profile';
$contact_class='active';
include 'includes/header.php';
if (!$session->is_signed_in()) {redirect("login.php");}
include 'includes/top_nav.php';
include 'includes/sidebar.php';

if (empty($_GET['id'])){
    redirect('users.php');
}
$user=User::find($_GET['id']);
if(isset($_POST['submit']))
{
    $user->employee_name=trim($_POST['employee_name']);
    $user->password=trim($_POST['password']);

    $user->set_file($_FILES['user_image']);
    $user->upload_photo();


    $prevQuery = "SELECT * FROM users WHERE username = '".$user->username."'";
    $prevResult = $database->query($prevQuery);

    if($prevResult->num_rows > 0){

        if(isset($_GET['id']) && $_GET['id']!=''){
            $getData=mysqli_fetch_assoc($prevResult);
            if($user->id==$getData['id']){
            }else{
                $message="Username already available in the portal";
            }
        }else{
            $message="Username already available in the portal";
        }
    }
        $user->save();
        redirect("index.php");
        $session->message("Profile updated successfully.");

}
?>

    <div id="content" class="content content-full-width">
    <div class="profile">
        <div class="profile-header">

            <div class="profile-header-cover"></div>


            <div class="profile-header-content">

                <div class="profile-header-img">
                    <img src="<?=$user->image_path_and_placeholder();?>" alt="">
                </div>


                <div class="profile-header-info">
                    <h4 class="mt-0 mb-1"><?=$user->employee_name?></h4>
                    <p class="mb-2"><?=ucwords($user->role)?></p>
                    <a href="#" class="btn btn-xs btn-yellow">Outlet Code: <?=$user->outlet_id?></a>
                </div>

            </div>


            <ul class="profile-header-tab nav nav-tabs">
                <li class="nav-item"><a href="#profile-post" class="nav-link active" data-toggle="tab">PROFILE</a></li>
            </ul>

        </div>
    </div>
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
                            <h4 class="panel-title">Edit Profile</h4>
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
                                    <label class="col-md-4 col-sm-4 col-form-label" for="employee_name">Employee Name * :</label>
                                    <div class="col-md-8 col-sm-8">
                                        <input class="form-control" type="text" value="<?=$user->employee_name?>" id="employee_name" name="employee_name" placeholder="Required" data-parsley-required="true" />
                                    </div>
                                </div>
                                <div class="form-group row m-b-15">
                                    <label class="col-md-4 col-sm-4 col-form-label" for="employee_name">Profile Image :</label>
                                    <div class="col-md-8 col-sm-8">
                                        <input class="form-control" type="file" id="user_image" name="user_image" />
                                    </div>
                                </div>
                                <div class="form-group row m-b-15">
                                    <label class="col-md-4 col-sm-4 col-form-label" for="outlet_id">Outlet * :</label>
                                    <div class="col-md-8 col-sm-8">
                                        <select disabled name="outlet_id" id="" class="form-control" data-parsley-required="true">
                                            <option value="">-Select Outlet-</option>
                                            <?php
                                            $outlet=Outlet::all();
                                            foreach ($outlet as $list) {
                                                if ($user->outlet_id==$list->outlet_code){
                                                    echo "<option selected value='".$list->outlet_code."'>";
                                                }else{
                                                    echo "</option> <option value='".$list->outlet_code."'>";
                                                }
                                                echo $list->outlet_name."</option>";

                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row m-b-15">
                                    <label class="col-md-4 col-sm-4 col-form-label" for="role">Role * :</label>
                                    <div class="col-md-8 col-sm-8">
                                        <select disabled name="role" id="" class="form-control" data-parsley-required="true">
                                            <?php
                                            $user_role=array('Administrator','Customer Care','Exchange','Financer','PDI','Stock Manager');
                                            foreach ($user_role as $list) {
                                                if ($user->role==strtolower($list)){
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
                                <div class="form-group row m-b-15">
                                    <label class="col-md-4 col-sm-4 col-form-label" for="username">Username * :</label>
                                    <div class="col-md-8 col-sm-8">
                                        <input disabled class="form-control" type="text" value="<?=$user->username?>" id="username" name="username" placeholder="Required" data-parsley-required="true" />
                                    </div>
                                </div>
                               <div class="form-group row m-b-15">
                                    <label class="col-md-4 col-sm-4 col-form-label" for="password">Password * :</label>
                                    <div class="col-md-8 col-sm-8">
                                        <input class="form-control" type="password" value="<?=$user->password?>" id="password" name="password" placeholder="Required" data-parsley-required="true" />
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
