<?php
$page_title='Import DMS Register';
$upload_class='active';
$dms_class='active';
include 'includes/header.php';
if (!$session->is_signed_in()) {redirect("login.php");}
include 'includes/top_nav.php';
include 'includes/sidebar.php';
$statusMsg='';
if(!empty($_GET['status'])){
    switch($_GET['status']){
        case 'succ':
            $type='Success';
            $statusType = 'alert-success';
            $statusMsg = 'Members data has been imported successfully.';
            break;
        case 'err':
            $type='Error';
            $statusType = 'alert-danger';
            $statusMsg = 'Some problem occurred, please try again.';
            break;
        case 'invalid_file':
            $type='Error';
            $statusType = 'alert-danger';
            $statusMsg = 'Please upload a valid CSV file.';
            break;
        default:
            $type='';
            $statusType = '';
            $statusMsg = '';
    }
}


?>

<div id="content" class="content">
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item"><a href="">Upload Centre</a></li>
        <li class="breadcrumb-item active"><?=$page_title?></li>
    </ol>


    <?php if ($statusMsg): ?>
        <div class="alert <?php echo $statusType; ?> fade show">
            <span class="close" data-dismiss="alert">×</span>
            <strong><?=$type?>!</strong>
            <?php echo $statusMsg; ?>
            <a href="#" class="alert-link"></a>.
        </div>
    <?php endif; ?>
    <h1 class="page-header"><?=$page_title?></h1>
    <div class="row">
        <div class="col-xl-12">
            <div class="col-xl-6">

                <div class="panel panel-inverse" data-sortable-id="form-validation-1">

                    <div class="panel-heading">
                        <h4 class="panel-title"><i class="fa fa-upload"></i></h4>
                        <div class="panel-heading-btn">
                            <div class="">
                                <a href="javascript:void(0);" class="btn btn-success" onclick="formToggle('importFrm');"><i class="plus"></i> Import</a>
                            </div>
                        </div>
                    </div>


                    <div class="panel-body" id="importFrm" style="display: none;">
                        <form class="form-horizontal" data-parsley-validate="true" method="post" action="importDMS.php" enctype="multipart/form-data">
                            <div class="form-group row m-b-15">
                                <label class="col-md-4 col-sm-4 col-form-label" for="file">Browse File * :</label>
                                <div class="col-md-8 col-sm-8">
                                    <input class="form-control" type="file" id="file" name="file" placeholder="Required" data-parsley-required="true" />
                                </div>
                            </div>


                            <div class="form-group row m-b-0">
                                <label class="col-md-4 col-sm-4 col-form-label">&nbsp;</label>
                                <div class="col-md-8 col-sm-8">
                                    <input type="submit" name="importSubmit" value="Upload" class="btn btn-primary">
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <script>
            function formToggle(ID){
                var element = document.getElementById(ID);
                if(element.style.display === "none"){
                    element.style.display = "block";
                }else{
                    element.style.display = "none";
                }
            }
        </script>

        <?php include 'includes/footer.php';?>
