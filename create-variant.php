<?php
$page_title='Create Variant';
$menu_class='active';
$variant_class='active';
include 'includes/header.php';
if (!$session->is_signed_in()) {redirect("login.php");}
include 'includes/top_nav.php';
include 'includes/sidebar.php';

$variant=new Variant();
if(isset($_POST['submit']))
{
    $variant->variant_name=trim($_POST['variant_name']);
    $variant->model_id=trim($_POST['model_id']);
    $variant->variant_code=trim($_POST['variant_code']);
    $variant->transmission=trim($_POST['transmission']);
    $variant->status=1;
    $prevQuery = "SELECT id FROM variants WHERE variant_code = '".$variant->variant_code."'";
    $prevResult = $database->query($prevQuery);

    if($prevResult->num_rows > 0){
        $message="Variant code already available in the portal";
    } else
    {
        $variant->save();
        redirect('variants.php');
        $session->message("New Variant {$variant->variant_name} created successfully.");
    }
}
?>
    <div id="content" class="content">
        <ol class="breadcrumb float-xl-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="variants.php">Variants</a></li>
            <li class="breadcrumb-item active"><?=$page_title?></li>
        </ol>


<?php if ($message): ?>
    <div class="alert alert-danger fade show">
        <span class="close" data-dismiss="alert">×</span>
        <strong>Success!</strong>
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
                            <h4 class="panel-title">New Variant</h4>
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
                                    <label class="col-md-4 col-sm-4 col-form-label" for="variant_name">Variant Name * :</label>
                                    <div class="col-md-8 col-sm-8">
                                        <input class="form-control" type="text" id="variant_name" name="variant_name" placeholder="Required" data-parsley-required="true" />
                                    </div>
                                </div>

                                <div class="form-group row m-b-15">
                                    <label class="col-md-4 col-sm-4 col-form-label" for="transmission">Transmission * :</label>
                                    <div class="col-md-8 col-sm-8">
                                        <select name="transmission" id="" class="form-control" data-parsley-required="true">
                                            <option value="">-Select Transmission-</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row m-b-15">
                                    <label class="col-md-4 col-sm-4 col-form-label" for="model_id">Model * :</label>
                                    <div class="col-md-8 col-sm-8">
                                        <select name="model_id" id="" class="form-control" data-parsley-required="true">
                                            <option value="">-Select Channel-</option>
                                            <?php $models=Model::all();
                                            foreach ($models as $model):?>
                                            <option value="<?=$model->id?>"><?=$model->model_name?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row m-b-15">
                                    <label class="col-md-4 col-sm-4 col-form-label" for="variant_code">Variant Code * :</label>
                                    <div class="col-md-8 col-sm-8">
                                        <input class="form-control" type="text" id="variant_code" name="variant_code" placeholder="Required" data-parsley-required="true" />
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
