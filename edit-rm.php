<?php
$page_title='Edit RM';
$menu_class='active';
$rm_class='active';
include 'includes/header.php';
if (!$session->is_signed_in()) {redirect("login.php");}
include 'includes/top_nav.php';
include 'includes/sidebar.php';

if (empty($_GET['id'])){
    redirect('rms.php');
}
$rm=Rm::find($_GET['id']);
if(isset($_POST['submit']))
{
    $rm->rm_name=trim($_POST['rm_name']);
    $rm->outlet_id=trim($_POST['outlet_id']);
    $prevQuery = "SELECT * FROM rms WHERE rm_name = '".$rm->rm_name."'";
    $prevResult = $database->query($prevQuery);

    if($prevResult->num_rows > 0){

        if(isset($_GET['id']) && $_GET['id']!=''){
            $getData=mysqli_fetch_assoc($prevResult);
            if($rm->id==$getData['id']){
            }else{
                $msg="RM already available in the portal";
            }
        }else{
            $message="RM already available in the portal";
        }
    }
    $rm->save();
    redirect('rms.php');
    $session->message("RM {$rm->rm_name} updated successfully.");
}
?>
    <div id="content" class="content">
        <ol class="breadcrumb float-xl-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="rms.php">RMs</a></li>
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
                            <h4 class="panel-title">Edit RM</h4>
                            <div class="panel-heading-btn">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                            </div>
                        </div>


                        <div class="panel-body">
                            <form class="form-horizontal" data-parsley-validate="true" method="post" action="">
                                <div class="form-group row m-b-15">
                                    <label class="col-md-4 col-sm-4 col-form-label" for="rm_name">RM Name * :</label>
                                    <div class="col-md-8 col-sm-8">
                                        <input class="form-control" type="text" value="<?=$rm->rm_name?>" id="rm_name" name="rm_name" placeholder="Required" data-parsley-required="true" />
                                    </div>
                                </div>
                                <div class="form-group row m-b-15">
                                    <label class="col-md-4 col-sm-4 col-form-label" for="outlet_name">Outlet * :</label>
                                    <div class="col-md-8 col-sm-8">
                                        <select name="outlet_id" id="" class="form-control" data-parsley-required="true">
                                            <option value="">-Select Outlet-</option>
                                            <?php
                                            $outlet=Outlet::all();
                                            foreach ($outlet as $list) {
                                                if ($rm->outlet_id==$list->id){
                                                    echo "<option selected value='".$list->id."'>";
                                                }else{
                                                    echo "</option> <option value='".$list->id."'>";
                                                }
                                                echo $list->outlet_name."</option>";

                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
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
