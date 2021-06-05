
<div id="sidebar" class="sidebar">
    <div data-scrollbar="true" data-height="100%">
        <ul class="nav">
            <li class="nav-profile">
                <a href="javascript:;" data-toggle="nav-profile">
                    <div class="cover with-shadow"></div>
                    <div class="image">
                        <img src="<?php echo $session_user->image_path_and_placeholder(); ?>" alt="" />
                    </div>
                    <div class="info">
                        <b class="caret pull-right"></b>
                        <?php echo $session_user->employee_name;?>
                        <small><?php echo ucwords($session_user->role)." (".$session_user->outlet_id.")";?></small>
                    </div>
                </a>
            </li>

        </ul>

        <ul class="nav">
            <li class="nav-header">SUMMARY</li>
            <li class="<?php echo $page_title=='Dashboard'?  $dashboard_class : '';?>">
                <a href="index.php">
                    <i class="ion-ios-pulse bg-gradient-pink"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            
            <li class="nav-header">SETTINGS</li>
           
            
            <li class="has-sub <?=$menu_class?>">
                <a href="javascript:;">
                    <b class="caret"></b>
                    <i class="ion-ios-cog"></i>
                    <span>Masters</span>
                </a>
                <ul class="sub-menu">
                    <li class="<?=$channel_class?>"><a href="channels.php">Channels</a></li>
                    <li class="<?=$outlet_class?>"><a href="outlets.php">Outlets</a></li>
                    <li class="<?=$model_class?>"><a href="models.php">Models</a></li>
                    <li class="<?=$variant_class?>"><a href="variants.php">Variants</a></li>
                    <li class="<?=$colors_class?>"><a href="colors.php">Colors</a></li>
                    <li class="<?=$srm_class?>"><a href="srms.php">SRM</a></li>
                    <li class="<?=$rm_class?>"><a href="rms.php">RM</a></li>
                    <li class="<?=$drivers_class?>"><a href="drivers.php">Drivers</a></li>
                    <li class="<?=$stock_class?>"><a href="stock-locations.php">Stock Locations</a></li>
                </ul>
            </li>
            <?php if($session_user->role=='administrator'):?>
            <li class="<?=$contact_class?>">
                <a href="users.php">
                    <i class="ion-ios-contact bg-gradient-yellow"></i>
                    <span>Users </span>
                </a>
            </li>
        <?php endif;?>
        <?php if($session_user->role=='administrator'):?>
            <li class="has-sub <?=$upload_class?>">
                <a href="javascript:;">
                    <b class="caret"></b>
                    <i class="ion-ios-cloud-upload bg-gradient-blue"></i>
                    <span>Upload Centre</span>
                </a>
                <ul class="sub-menu">
                    
                    <li class="<?=$dispatch_class?>"><a href="dispatches.php">Dispatches</a></li>
                    <li class="<?=$dms_class?>"><a href="dms.php">DMS Invoices</a></li>
                    <li class="<?=$sms_class?>"><a href="sms.php">SMS Invoices</a></li>
                    
                </ul>
            </li>
            <?php endif;?>

            <li class="nav-header">SALES DEPARTMENT</li>


                <li class="has-sub <?=$group_class?>">
                    <a href="javascript:;">
                        <b class="caret"></b>
                        <i class="ion-ios-color-filter bg-green"></i>
                        <span>Group Stock</span>
                    </a>
                    <ul class="sub-menu">
                        <li class="<?=$arena_class?>"><a href="group-arena.php">ARENA</a></li>
                        <li class="<?=$nexa_class?>"><a href="group-nexa.php">NEXA</a></li>
                        <li class="<?=$commercial_class?>"><a href="group-commercial.php">COMMERCIAL</a></li>

                    </ul>
                </li>


            <?php if($session_user->role=='pdi' || $session_user->role=='administrator'):?>
            <li class="<?=$pdi_class?>">
                <a href="pdi.php">
                    <i class="ion-ios-medkit bg-gradient-orange"></i>
                    <span>Pre Delivery Inspection </span>
                </a>
            </li>
            <?php endif;?>
            <?php if($session_user->role=='stock manager' || $session_user->role=='administrator'):?>
            <li class="<?=$allotment_class?>">
                <a href="allotment.php">
                    <i class="ion-ios-pricetags bg-gradient-purple"></i>
                    <span>Allotment </span>

                </a>
            </li>
           
            <li class="has-sub <?=$branch_class?>">
                <a href="javascript:;">
                    <b class="caret"></b>
                    <i class="ion-ios-airplane bg-green"></i>
                    <span>Branch Transfers</span>
                </a>
                <ul class="sub-menu">
                    <li class="<?=$indent_class?>"><a href="indents.php">Indents</a></li>
                    <li class="<?=$view_request_class?>"><a href="view-requests.php">View Requests</a></li>
                    <li class="<?=$grp_class?>"><a href="group-indents.php">Group Indents</a></li>

                </ul>
            </li>
            <?php endif;?>
            <?php if($session_user->role=='customer care' || $session_user->role=='administrator' || $session_user->role=='stock manager'  ):?>
            <li class="has-sub <?=$delivery_menu_class?>">
                <a href="javascript:;">
                    <b class="caret"></b>
                    <i class="ion-ios-cart bg-gradient-red"></i>
                    <span>Delivery Area</span>
                </a>
                <ul class="sub-menu">
                    <li class="<?=$delivery_class?>"><a href="deliveries.php">Deliveries</a></li>
                    <li class="<?=$del_reg_class?>"><a href="delivery-register.php">Delivery Register</a></li>
                </ul>
            </li>

            <?php endif;?>
            <?php if($session_user->role=='financer' || $session_user->role=='administrator'):?>
            <li class="nav-header">FINANCE DEPARTMENT</li>
            <li class="has-sub <?=$finance_class?>">
                <a href="javascript:;">
                    <b class="caret"></b>
                    <i class="ion-ios-wallet bg-gradient-yellow"></i>
                    <span>Finance</span>
                </a>
                <ul class="sub-menu">
                    <li class="<?=$bank_class?>"><a href="banks.php">Banks</a></li>
                    <li class="<?=$bank_status_class?>"><a href="finance.php">Update Finance Status</a></li>
                </ul>
            </li>
            <?php endif;?>


            <?php if($session_user->role=='exchange' || $session_user->role=='administrator'):?>
            <li class="nav-header">EXCHANGE DEPARTMENT</li>
            <li class="has-sub <?=$exchange_class?>">
                <a href="javascript:;">
                    <b class="caret"></b>
                    <i class="ion-ios-switch bg-pink-transparent-6"></i>
                    <span>Exchange</span>
                </a>
                <ul class="sub-menu">
                    <li class="<?=$exch_status_class?>"><a href="exchange.php">Exchange Status</a></li>
                </ul>
            </li>
            <?php endif;?>

            <li>
                <a href="javascript:" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="ion-ios-arrow-back"></i> <span>Collapse</span></a>
            </li>
        </ul>
    </div>
</div>
<div class="sidebar-bg"></div>
