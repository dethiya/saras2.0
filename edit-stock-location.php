<?php
$page_title='Edit Stock Location';
$menu_class='active';
$stock_class='active';
include 'includes/header.php';
if (!$session->is_signed_in()) {redirect("login.php");}
include 'includes/top_nav.php';
include 'includes/sidebar.php';

if (empty($_GET['id'])){
    redirect('stock-locations.php');
    $session->message='Stock Location update successfully.';
}
$stock_loc=StockLocation::find($_GET['id']);
if(isset($_POST['update']))
{
    $stock_loc->stock_loc_name=trim($_POST['stock_loc_name']);

    $prevQuery = "SELECT id FROM stock_locations WHERE stock_loc_name = '".$stock_loc->stock_loc_name."'";
    $prevResult = $database->query($prevQuery);

    if($prevResult->num_rows > 0){

        if(isset($_GET['id']) && $_GET['id']!=''){
            $getData=mysqli_fetch_assoc($prevResult);
            if($stock_loc->id==$getData['id']){
            }else{
                $msg="Stock Location already available in the portal";
            }
        }else{
            $message="Stock Location already available in the portal";
        }
    }
    $stock_loc->save();
    redirect('stock-locations.php');
    $session->message("Stock Location {$stock_loc->stock_loc_name} updated successfully.");
}
?>
    <div id="content" class="content">
        <ol class="breadcrumb float-xl-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="stock-locations.php">Stock Locations</a></li>
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
                            <h4 class="panel-title">Edit Stock Location</h4>
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
                                    <label class="col-md-4 col-sm-4 col-form-label" for="stock_loc_name">Stock Location Name * :</label>
                                    <div class="col-md-8 col-sm-8">
                                        <input class="form-control" type="text" value="<?=$stock_loc->stock_loc_name?>" id="stock_loc_name" name="stock_loc_name" placeholder="Required" data-parsley-required="true" />
                                    </div>
                                </div>

                                <div class="form-group row m-b-15">
                                    <label class="col-md-4 col-sm-4 col-form-label" for="stock_loc_code">Stock Location Code * :</label>
                                    <div class="col-md-8 col-sm-8">
                                        <input class="form-control" type="text" value="<?=$stock_loc->stock_loc_code?>" id="stock_loc_code" name="stock_loc_code" placeholder="Required" data-parsley-required="true" />
                                    </div>
                                </div>

                                <div class="form-group row m-b-0">
                                    <label class="col-md-4 col-sm-4 col-form-label">&nbsp;</label>
                                    <div class="col-md-8 col-sm-8">
                                        <button type="submit" name="update" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>

            </div>
        </div>
    </div>

<?php include 'includes/footer.php';?>