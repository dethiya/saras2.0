<?php
$page_title="Login Page";
require_once "includes/init.php";
$the_message="";
if($session->is_signed_in()){ redirect("index.php");}

if (isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    ///Method to check database user

    $user_found=User::verify_user($username,$password);
    if ($user_found) {
        if ($user_found->status==1){
            $session->login($user_found);
            redirect("index.php");
        }else{
            $the_message="Unauthorized Access.";
        }
    } else {
        $the_message = "Your Username or password is incorrect";
    }
} else {
    $username = "";
    $password = "";
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Login Page | SARAS 2.0</title>
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <link rel="icon" href="images/mi5.ico"  type="image/icon type">
        <link href="assets/css/apple/app.min.css" rel="stylesheet" />
        <link href="assets/plugins/ionicons/css/ionicons.min.css" rel="stylesheet" />
    </head>
    <body class="pace-top">
        <div id="page-loader" class="fade show">
            <span class="spinner"></span>
        </div>

        <div class="login-cover">
            <div class="login-cover-image" style="background-image: url(assets/img/login-bg/login-bg-13.jpg);" data-id="login-cover-image"></div>
            <div class="login-cover-bg"></div>
        </div>


        <div id="page-container" class="fade">
            <div class="login login-v2" data-pageload-addclass="animated fadeIn">
                <div class="login-header">
                    <div class="brand">
                        <span class="logo"><i class="ion-ios-finger-print"></i></span> <b>SARAS</b> 2.0
                        <small>Sign in to start your session</small>
                    </div>
                    <div class="icon">
                        <i class="fa fa-lock"></i>
                    </div>
                </div>

                <div class="login-content">
                    <?php if ($the_message):?>
                        <div class="alert alert-danger fade show">
                            <span class="close" data-dismiss="alert">×</span>
                            <strong>Security Alert!</strong>
                            <?=$the_message?>
                            <a href="#" class="alert-link"></a>.
                        </div>

                    <?php endif;?>
                    <form action="" method="post" class="margin-bottom-0">
                        <div class="form-group m-b-20">
                            <input type="text" name="username" class="form-control form-control-lg" placeholder="Enter Username" required />
                        </div>
                        <div class="form-group m-b-20">
                            <input type="password" name="password" class="form-control form-control-lg" placeholder="Enter Password" required />
                        </div>
                        <div class="login-buttons">
                            <button type="submit" name="submit" class="btn btn-success btn-block btn-lg">Sign me in</button>
                        </div>
                        <div class="m-t-20">Design & Developed By  <a href="javascript:;">MI5 Prosystems Pvt. Ltd.</a> </div>
                    </form>
                </div>
            </div>

            <ul class="login-bg-list clearfix">
                <li ><a href="javascript:;" data-click="change-bg" data-img="assets/img/login-bg/login-bg-17.jpg" style="background-image: url(assets/img/login-bg/login-bg-17.jpg);"></a></li>
                <li><a href="javascript:;" data-click="change-bg" data-img="assets/img/login-bg/login-bg-16.jpg" style="background-image: url(assets/img/login-bg/login-bg-16.jpg);"></a></li>
                <li><a href="javascript:;" data-click="change-bg" data-img="assets/img/login-bg/login-bg-15.jpg" style="background-image: url(assets/img/login-bg/login-bg-15.jpg);"></a></li>
                <li><a href="javascript:;" data-click="change-bg" data-img="assets/img/login-bg/login-bg-14.jpg" style="background-image: url(assets/img/login-bg/login-bg-14.jpg);"></a></li>
                <li class="active"><a href="javascript:;" data-click="change-bg" data-img="assets/img/login-bg/login-bg-13.jpg" style="background-image: url(assets/img/login-bg/login-bg-13.jpg);"></a></li>
                <li><a href="javascript:;" data-click="change-bg" data-img="assets/img/login-bg/login-bg-12.jpg" style="background-image: url(assets/img/login-bg/login-bg-12.jpg);"></a></li>
            </ul>

           

            <a href="javascript:;" class="btn btn-icon btn-circle btn-primary btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
        </div>

        <script src="assets/js/app.min.js"></script>
        <script src="assets/js/theme/apple.min.js"></script>
        <script src="assets/js/demo/login-v2.demo.js"></script>
    </body>
</html>
