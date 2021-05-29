<div id="header" class="header navbar-default">
                <div class="navbar-header">
                    <a href="index.html" class="navbar-brand">
                        <span class="navbar-logo"><i class="ion-ios-finger-print"></i></span> <b class="mr-1">SARAS</b> 2.0
                    </a>
                    <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>

                <ul class="navbar-nav navbar-right">
                    <li class="navbar-form">
                        <form action="search.php" method="GET" name="search_form">
                            <div class="form-group">
                                <input type="text" name="text_search" class="form-control" placeholder="Enter keyword" />
                                <button type="submit" name="btn_search" class="btn btn-search"><i class="ion-ios-search"></i></button>
                            </div>
                        </form>
                    </li>



                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle icon" aria-expanded="false">
                            <i class="ion-ios-notifications"></i>
                            <span class="label" id="notification_allotments"></span>
                        </a>
                        <div class="dropdown-menu media-list dropdown-menu-right" style="">
                            <div class="dropdown-header" id="notification_allotments">TODAY'S ALLOTMENTS </div>
                                <div id="new_allotments"></div>



                        </div>
                    </li>

                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle icon" aria-expanded="false">
                            <i class="ion-ios-car"></i>
                            <span class="label" id="deliveries"></span>
                        </a>
                        <div class="dropdown-menu media-list dropdown-menu-right" style="">
                            <div class="dropdown-header" id="notification_allotments">TODAY'S DELIVERIES </div>
                            <div id="new_delivery"></div>



                        </div>
                    </li>
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle icon" aria-expanded="false">
                            <i class="ion-ios-airplane"></i>
                            <span class="label" id="new_indents"></span>
                        </a>

                    </li>


                    <li class="dropdown navbar-user">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="<?php echo $session_user->image_path_and_placeholder(); ?>" alt="" />
                            <span class="d-none d-md-inline"><?php echo $session_user->employee_name; ?></span> <b class="caret"></b>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="edit-profile.php?id=<?=$session_user->id?>" class="dropdown-item">Edit Profile</a>
                            <div class="dropdown-divider"></div>
                            <a href="logout.php" class="dropdown-item">Log Out</a>
                        </div>
                    </li>
                </ul>
            </div>