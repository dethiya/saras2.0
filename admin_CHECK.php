<?php 
	$page_title='Dashboard';
 	$dashboard_class='active';
 	include 'includes/header.php';
 	if (!$session->is_signed_in()) {redirect("login.php");}
 	include 'includes/top_nav.php';
 	include 'includes/sidebar.php';
 ?>

<div id="content" class="content">
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <h1 class="page-header">Dashboard <small><?=$session_user->role=='administrator'?'(Group)':$session_user->outlet_id?></small></h1>
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="widget widget-stats bg-white text-inverse">
                <div class="stats-icon stats-icon-square bg-gradient-purple text-white"><i class="ion-ios-pricetags"></i></div>
                <div class="stats-content">
                    <div class="stats-title text-inverse-lighter">ALLOTMENTS</div>
                    <div class="stats-number"><div id="total_alloted"></div>
                    </div>
                    <div class="stats-progress progress">
                        <div class="progress-bar" style="width: 70.1%;"></div>
                    </div>
                    <div class="stats-desc text-inverse-lighter"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="widget widget-stats bg-white text-inverse">
                <div class="stats-icon stats-icon-square bg-gradient-yellow text-white"><i class="ion-ios-cash"></i></div>
                <div class="stats-content">
                    <div class="stats-title text-inverse-lighter">FPR</div>
                    <div class="stats-number"><div id="total_fpr"></div></div>
                    <div class="stats-progress progress">
                        <div class="progress-bar" style="width: 40.5%;"></div>
                    </div>
                    <div class="stats-desc text-inverse-lighter"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="widget widget-stats bg-white text-inverse">
                <div class="stats-icon stats-icon-square bg-gradient-green text-white"><i class="ion-ios-airplane"></i></div>
                <div class="stats-content">
                    <div class="stats-title text-inverse-lighter">BRANCH TRANSERS</div>
                    <div class="stats-number"><div id="total_transfers"></div></div>
                    <div class="stats-progress progress">
                        <div class="progress-bar" style="width: 40.5%;"></div>
                    </div>
                    <div class="stats-desc text-inverse-lighter"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="widget widget-stats bg-white text-inverse">
                <div class="stats-icon stats-icon-square bg-gradient-blue text-white"><i class="ion-ios-car"></i></div>
                <div class="stats-content">
                    <div class="stats-title text-inverse-lighter">FREE</div>
                    <div class="stats-number"><div id="total_free"></div></div>
                    <div class="stats-progress progress">
                        <div class="progress-bar" style="width: 54.9%;"></div>
                    </div>
                    <div class="stats-desc text-inverse-lighter"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-6 ui-sortable">
            <div class="panel panel-inverse" data-sortable-id="table-basic-1">
                <div class="panel-heading ui-sortable-handle">
                    <h4 class="panel-title">NAC Stock - Live <i class="ion-ios-pulse"></i> </h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-responsive-sm dt_pdi">
                            <thead>
                            <tr>
                                <th>SN</th>
                                <th>Locations</th>
                                <th width="15%">FPR</th>
                                <th width="15%">Allotted</th>
                                <th width="15%">BT</th>
                                <th width="15%">Free</th>
                                <th width="15%">Total</th>
                            </tr>
                            </thead>
                        
                        </table>
                    </div>
                </div>
            </div>
        </div>

<!--Indents Notifications -->

        <div class="col-xl-6 col-lg-6">

            <div class="panel panel-inverse" data-sortable-id="index-2">
                <div class="panel-heading">
                    <h4 class="panel-title">Branch Transfers Requests <i class="ion-ios-airplane"></i></h4>
                    <span class="label bg-blue">4 message</span>
                </div>
                <div class="panel-body bg-silver">
                    <div class="chats" id="indent_notifications" data-scrollbar="true" data-height="225px">

                    </div>
                </div>

            </div>

    </div>
<!--    end of row-->
</div>

<?php include 'includes/footer.php';?>