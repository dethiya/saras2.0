<?php
$page_title='Create SRM';
$menu_class='active';
$srm_class='active';
include 'includes/header.php';
if (!$session->is_signed_in()) {redirect("login.php");}
include 'includes/top_nav.php';
include 'includes/sidebar.php';

$srm=new Srm();
if(isset($_POST['submit']))
{
    $srm->srm_name=trim($_POST['srm_name']);
    $srm->outlet_id=trim($_POST['outlet_id']);
    $srm->status=1;
    $prevQuery = "SELECT id FROM srms WHERE srm_name = '".$srm->srm_name."'";
    $prevResult = $database->query($prevQuery);

    if($prevResult->num_rows > 0){
        $message="SRM already available in the portal";
    } else
    {
        $srm->save();
        redirect('srms.php');
        $session->message("New SRM {$srm->srm_name} with id: {$srm->id} created successfully.");
    }
}
?>
    <div id="content" class="content">
        <ol class="breadcrumb float-xl-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="srms.php">SRM</a></li>
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
                            <h4 class="panel-title">New SRM</h4>
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
                                    <label class="col-md-4 col-sm-4 col-form-label" for="srm_name">SRM Name * :</label>
                                    <div class="col-md-8 col-sm-8">
                                        <input class="form-control" type="text" id="srm_name" name="srm_name" placeholder="Required" data-parsley-required="true" />
                                    </div>
                                </div>
                                <div class="form-group row m-b-15">
                                    <label class="col-md-4 col-sm-4 col-form-label" for="outlet_id">Outlet * :</label>
                                    <div class="col-md-8 col-sm-8">
                                        <select name="outlet_id" id="" class="form-control" data-parsley-required="true">
                                            <option value="">-Select Outlet-</option>
                                            <?php $outlets=Outlet::all();
                                            foreach ($outlets as $outlet):?>
                                            <option value="<?=$outlet->id?>"><?=$outlet->outlet_name?></option>
                                            <?php endforeach;?>
                                        </select>
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

<?php include 'includes/footer.php';?>