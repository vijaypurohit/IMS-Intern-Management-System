<?php
/**
 * Created by PhpStorm.
 * User: vijay
 * Date: 16-May-19
 * Time: 2:42 PM
 */

// sign in page using modal and bottom floating button

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
    <!-- MODAL Default Size -->
                <div class="modal fade" id="loginModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="defaultModalLabel">Sign in to start your session</h4>
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
                                    <div class="row">
                                        <div class="col-xs-8 p-t-5">
                                            <input type="checkbox" name="rememberme" id="rememberme"
                                                   class="filled-in chk-col-pink" checked>
                                            <label for="rememberme">Remember Me</label>
                                        </div>
                                    </div>
                                </div>
        <!--modal body-->

                                <div class="modal-footer">
                                    <button type="submit" name="login_btn_" data-color="blue" class="btn bg-blue waves-effect">SIGN IN!</button>
                                    <button type="button" data-color="black" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                                </div>
                            </form>
                        </div>
        <!--modal content-->
                    </div>
<!--        modal dialog-->
                </div>

    <!-- FLOAT BUTTON -->
        <div class="" style="position: fixed; right: 25px; bottom: 21px ">
            <button type="button" class="btn btn-default btn-circle-lg waves-effect waves-circle waves-float waves-red" data-toggle="modal" data-target="#loginModal">
                <i class="material-icons">settings</i>
            </button>
        </div>
    <!--END FLOAT BUTTON -->
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


<!--        <div class="card">-->
<!--            <div class="body">-->
<!--                <form id="sign_in" method="POST">-->
<!--                    <div class="msg">Sign in to start your session</div>-->
<!--                    <div class="input-group">-->
<!--                        <span class="input-group-addon">-->
<!--                            <i class="material-icons">person</i>-->
<!--                        </span>-->
<!--                        <div class="form-line">-->
<!--                            <input type="text" class="form-control" name="username" placeholder="Username" required autofocus>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="input-group">-->
<!--                        <span class="input-group-addon">-->
<!--                            <i class="material-icons">lock</i>-->
<!--                        </span>-->
<!--                        <div class="form-line">-->
<!--                            <input type="password" class="form-control" name="password" placeholder="Password" required>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="row">-->
<!--                        <div class="col-xs-8 p-t-5">-->
<!--                            <input type="checkbox" name="rememberme" id="rememberme" class="filled-in chk-col-pink">-->
<!--                            <label for="rememberme">Remember Me</label>-->
<!--                        </div>-->
<!--                        <div class="col-xs-4">-->
<!--                            <button class="btn btn-block bg-pink waves-effect" type="submit" name="login_btn">SIGN IN</button>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="row m-t-15 m-b--20">-->
<!--                        <div class="col-xs-6">-->
<!--                            <a href="sign-up.html" target="_blank">Register Now!</a>-->
<!--                        </div>-->
<!--                        <div class="col-xs-6 align-right">-->
<!--                            <a href="forgot-password.html" target="_blank">Forgot Password?</a>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </form>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->