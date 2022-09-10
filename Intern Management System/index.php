<?php
/**
 * Created by PhpStorm.
 * User: vijay
 * Date: 16-May-19
 * Time: 2:42 PM
 */


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
    <!-- GEAR CSS -->
    <link href="assets/css/gear.css" rel="stylesheet" />
<!--    --><?php //echo $asset_path_link; ?>

</head>
<!-- ----------------------------------------- END HTML HEADER ------------------------------------------------------------ -->
<!-- ----------------------------------------- HTML BODY ------------------------------------------------------------ -->
<body class="login-page" style="background-color: #007384;">
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
    <div class="logo " style="font-family: Iceland,serif !important;">
        <a href="javascript:void(0);" style="font-family: Iceland,serif !important;font-size: 50px !important; letter-spacing: 1px !important;"><?php echo APP_TITLE0 ?><b style="font-family: Iceland,serif !important;">  <?php echo APP_TITLE1 ?></b></a>
        <small style="font-family: Iceland,serif !important;font-size: 25px !important; letter-spacing: 1px !important;" >Intern Management System</small>
    </div>
</div>
<div class="col-md-6 col-md-offset-6">
    <!-- display form error messages  -->
    <?php include(INCLUDE_PATH . "/layouts/_messages.php") ?>
    <br>
    <br>
</div>

<div class="row clearfix" >
        <div id="level">
            <div id="content" style="padding-top: 45px">
                <div id="gears">
                    <div id="gears-static"></div>
                    <div id="gear-system-1">
                        <div class="shadow" id="shadow15"></div>
                        <div id="gear15"></div>
                        <div class="shadow" id="shadow14"></div>
                        <div id="gear14"></div>
                        <div class="shadow" id="shadow13"></div>
                        <div id="gear13"></div>
                    </div>
                    <div id="gear-system-2">
                        <div class="shadow" id="shadow10"></div>
                        <div id="gear10"></div>
                        <div class="shadow" id="shadow3"></div>
                        <div id="gear3"></div>
                    </div>
                    <div id="gear-system-3">
                        <div class="shadow" id="shadow9"></div>
                        <div id="gear9"></div>
                        <div class="shadow" id="shadow7"></div>
                        <div id="gear7"></div>
                    </div>
                    <div id="gear-system-4">
                        <div class="shadow" id="shadow6"></div>
                        <div id="gear6"></div>
                        <div id="gear4"></div>
                    </div>
                    <div id="gear-system-5">
                        <div class="shadow" id="shadow12"></div>
                        <div id="gear12"></div>
                        <div class="shadow" id="shadow11"></div>
                        <div id="gear11"></div>
                        <div class="shadow" id="shadow8"></div>
                        <div id="gear8"></div>
                    </div>
                    <div class="shadow" id="shadow1"></div>
                    <div id="gear1"></div>
                    <div id="gear-system-6">
                        <div class="shadow" id="shadow5"></div>
                        <div id="gear5"></div>
                        <div id="gear2"></div>
                    </div>
                    <div class="shadow" id="shadowweight"></div>
                    <div id="chain-circle"></div>
                    <div id="chain"></div>
                    <div id="weight"></div>
                </div>
                <div id="title" style="padding-top: 20px; ">
                    <div class="row clearfix">
                        <div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-3">
<!--                        style="width: 60%; vertical-align: middle;display: inline-block"-->
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
<!---->
                    </div>

<!--                    <div style="text-align:  right; color: #fff; font-size: 14px;  line-height: 20px;  padding-top: 20px; letter-spacing: 1px;">-->
<!--                       Developed & Maintained by:<br>-->
<!--                        Vijay Purohit<br>-->
<!--                        <a href="mailto:vijay.pu9@gmail.com" style="color: inherit">vijay.pu9@gmail.com</a>-->
<!--                    </div>-->

                </div>
            </div>
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