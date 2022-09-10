<?php
/**
 * Created by PhpStorm.
 * User: vijay
 * Date: 16-May-19
 * Time: 2:42 PM
 */

// page with normal card sign in box

$asset_path_link='';
$from_url_path = 'main_login';
$jqueryValidate=1;

require_once('config.php');
require_once(INCLUDE_PATH . '/logic/userSignup.php');

$subTitle = 'LOGIN '.base64_decode('WyB2aWpheWNoaXR0aSBda');
?>
<!DOCTYPE html>
<html lang="en">

<!-- ----------------------------------------- HTML HEADER ------------------------------------------------------------ -->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?php echo APP_TITLE." - ".$subTitle ?></title>
    <?php require_once ('includes/layouts/_header.php'); ?>
</head>
<!-- ----------------------------------------- END HTML HEADER ------------------------------------------------------------ -->
<!-- ----------------------------------------- HTML BODY ------------------------------------------------------------ -->
<body class="login-page">
<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="preloader">
            <div class="spinner-layer pl-red">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
        </div>
        <p>Please wait...</p>
    </div>
</div>
<!-- #END# Page Loader -->
<div class="login-box">
    <div class="logo" style="font-family: Iceland,serif !important;">
        <a href="javascript:void(0);" style="font-family: Iceland,serif !important;font-size: 50px !important; letter-spacing: 1px !important;"><?php echo APP_TITLE0 ?><b style="font-family: Iceland,serif !important;">  <?php echo APP_TITLE1 ?></b></a>
        <small style="font-family: Iceland,serif !important;font-size: 25px !important; letter-spacing: 1px !important;" >Intern Management System</small>
    </div>
    <!-- display form error messages  -->
    <?php include(INCLUDE_PATH . "/layouts/_messages.php") ?>
    <br>
    <br>
    <div class="card" role="document" >
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="">Sign in to start your session</h4>
            </div>
            <form id="sign_in" action="index.php" method="POST">
                <div class="modal-body">
                    <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">person</i>
                                </span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="username" placeholder="Username" required autofocus>
                        </div>
                    </div>
                    <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">lock</i>
                                </span>
                        <div class="form-line has-error">
                            <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>

                        </div>
                    </div>

                </div><!--modal body-->

                <div class="modal-footer">
                    <button type="submit" name="login_btn_" data-color="blue" class="btn bg-blue waves-effect">SIGN IN!</button>
                </div>
            </form>
        </div>
        <!--modal content-->
    </div>
</div>
</body>
<!-- -----------------------------------------END HTML BODY ------------------------------------------------------------ -->

<!-- ----------------------------------------- HTML FOOTER ------------------------------------------------------------ -->
<?php require_once ('includes/layouts/_footer.php'); ?>
<!-- Custom Js -->
<script src="assets/bsb/js/pages/ui/modals.js"></script>
<script src="assets/bsb/js/pages/examples/sign-in.js"></script>

<!-- ----------------------------------------- END HTML FOOTER ------------------------------------------------------------ -->
</html>