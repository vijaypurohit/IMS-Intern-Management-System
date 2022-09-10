<?php
/**
 * Created by PhpStorm.
 * User: Vijay Purohit
 * Date: 20-Jun-19
 * Time: 2:59 PM
 * Project: ims_vj
 */
$asset_path_link = "../";
require_once($asset_path_link . 'config.php');
$subTitle = 'ERROR 404 '.base64_decode('WyB2aWpheWNoaXR0aSBda');
$asset_path_link = $folder_name."/";
?>
<!DOCTYPE html>
<html lang="en">

<!-- ----------------------------------------- HTML HEADER ------------------------------------------------------------ -->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?php echo APP_TITLE." - ".$subTitle ?></title>
    <!-- Favicon-->
    <link rel="icon" href="<?php echo $asset_path_link; ?>assets/favicon.ico" type="image/x-icon">
    <!-- Google Fonts -->
    <link href="<?php echo $asset_path_link; ?>assets/css/font_material_icons.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $asset_path_link; ?>assets/css/font_roboto.css" rel="stylesheet" type="text/css">
    <!-- Bootstrap Core Css -->
    <link href="<?php echo $asset_path_link; ?>assets/bsb/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="<?php echo $asset_path_link; ?>assets/bsb/plugins/node-waves/waves.css" rel="stylesheet" />
    <!-- Custom Css -->
    <link href="<?php echo $asset_path_link; ?>assets/bsb/css/style.css" rel="stylesheet">
    <style>
        * {
            font-family: Comfortaa, serif;
            /*font-weight: normal;*/
            /*font-size: 1.04em;*/
        }
    </style>
</head>
<body class="four-zero-four">
<div class="four-zero-four-container">
    <div class="error-code">404</div>
    <div class="error-message">This page doesn't exist</div>
    <div class="button-place">
        <a href="<?php echo $asset_path_link; ?>index.php" class="btn btn-default btn-lg waves-effect">GO TO HOMEPAGE</a>
    </div>
</div>

<!-- Jquery Core Js -->
<script src="<?php echo $asset_path_link; ?>assets/bsb/plugins/jquery/jquery.min.js"></script>

<!-- Bootstrap Core Js -->
<script src="<?php echo $asset_path_link; ?>assets/bsb/plugins/bootstrap/js/bootstrap.js"></script>
<!-- Waves Effect Plugin Js -->
<script src="<?php echo $asset_path_link; ?>assets/bsb/plugins/node-waves/waves.js"></script>
<!-- Custom Js -->


<!-- ----------------------------------------- END HTML FOOTER ------------------------------------------------------------ -->
</html>
