<?php //echo $asset_path_link;
// HEADER FILES
?>
<!--
   _____   _____                _____     _____   __  __    _____
  / ____| |  __ \      /\      / ____|   |_   _| |  \/  |  / ____|
 | |      | |  | |    /  \    | |          | |   | \  / | | (___
 | |      | |  | |   / /\ \   | |          | |   | |\/| |  \___ \
 | |____  | |__| |  / ____ \  | |____     _| |_  | |  | |  ____) |
  \__vp_| |_____/  /_/    \_\  \_____|   |_____| |_|  |_| |_____/
  CDAC ATC JAIPUR - INTERN MANAGEMENT SYSTEM
-->

    <!-- Favicon-->
    <link rel="icon" href="<?php echo $asset_path_link; ?>assets/favicon.ico" type="image/x-icon">
    <!-- Google Fonts -->
    <!--    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">-->
    <!--    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">-->
    <link href="<?php echo $asset_path_link; ?>assets/css/font_roboto.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $asset_path_link; ?>assets/css/font_iceland.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $asset_path_link; ?>assets/css/font_comfortaa.css" rel="stylesheet" type="text/css">
<!--<link href=".--><?php //echo $asset_path_link; ?><!--assets/css/font_jura.css" rel="stylesheet" type="text/css">-->
<!--<link href="--><?php //echo $asset_path_link; ?><!--assets/css/font_opensans.css" rel="stylesheet" type="text/css">-->
<!--<link href="--><?php //echo $asset_path_link; ?><!--assets/css/font_playfair.css" rel="stylesheet" type="text/css">-->
<!--<link href="--><?php //echo $asset_path_link; ?><!--assets/css/font_raleway.css" rel="stylesheet" type="text/css">-->
<!--<link href="--><?php //echo $asset_path_link; ?><!--assets/css/font_nunito.css" rel="stylesheet" type="text/css">-->
<!--<link href="--><?php //echo $asset_path_link; ?><!--assets/css/font_quicksand.css" rel="stylesheet" type="text/css">-->
    <link href="<?php echo $asset_path_link; ?>assets/css/font_material_icons.css" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="<?php echo $asset_path_link; ?>assets/bsb/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="<?php echo $asset_path_link; ?>assets/bsb/plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="<?php echo $asset_path_link; ?>assets/bsb/plugins/animate-css/animate.css" rel="stylesheet" />

<?php if(isset($multiSelect) && $multiSelect==1) : ?>
    <!-- Colorpicker Css -->
    <link href="<?php echo $asset_path_link; ?>assets/bsb/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css" rel="stylesheet" />

    <!-- Dropzone Css -->
    <link href="<?php echo $asset_path_link; ?>assets/bsb/plugins/dropzone/dropzone.css" rel="stylesheet">

    <!-- Multi Select Css -->
    <link href="<?php echo $asset_path_link; ?>assets/bsb/plugins/multi-select/css/multi-select.css" rel="stylesheet">

    <!-- Bootstrap Spinner Css -->
    <link href="<?php echo $asset_path_link; ?>assets/bsb/plugins/jquery-spinner/css/bootstrap-spinner.css" rel="stylesheet">

    <!-- Bootstrap Tagsinput Css -->
    <link href="<?php echo $asset_path_link; ?>assets/bsb/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet">

    <!-- Bootstrap Select Css -->
    <link href="<?php echo $asset_path_link; ?>assets/bsb/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

    <!-- noUISlider Css -->
    <link href="<?php echo $asset_path_link; ?>assets/bsb/plugins/nouislider/nouislider.min.css" rel="stylesheet" />
<?php  endif ?>

<?php if( isset($bootstrap_select) && $bootstrap_select==1): ?>
    <!-- Bootstrap Select Css -->
    <link href="<?php echo $asset_path_link; ?>assets/bsb/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
<?php endif ?>

<?php if(isset($jqueryDataTable) && $jqueryDataTable==1) : ?>
    <!-- Jquery DataTable CSS Default -->
    <link href="<?php echo $asset_path_link ?>assets/bsb/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
    <!-- FOR ROWS GROUPING IN DT -->
    <link href="<?php echo $asset_path_link ?>assets/plugins/DataTables/RowGroup-1.1.0/css/rowGroup.dataTables.css" rel="stylesheet">
    <!-- COLUMN VISIBILITY -->
    <link href="<?php echo $asset_path_link ?>assets/plugins/DataTables/Buttons-1.5.6/css/buttons.dataTables.min.css" rel="stylesheet">
<?php endif ?>

<?php if(isset($dateTimePicker) && $dateTimePicker==1) : ?>
    <!-- Bootstrap Material Datetime Picker Css -->
    <link href="<?php echo $asset_path_link ?>assets/bsb/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />
    <!-- Bootstrap DatePicker Css -->
    <link href="<?php echo $asset_path_link ?>assets/bsb/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />
<?php endif ?>

<!-- Custom Css -->
<link href="<?php echo $asset_path_link; ?>assets/bsb/css/style.css" rel="stylesheet">

<?php if(!$from_url_path=='main_login'  || $from_url_path=='admin' || $from_url_path=='intern'): ?>
    <!-- Themes. -->
    <link href="<?php echo $asset_path_link ?>assets/bsb/css/themes/all-themes.css" rel="stylesheet" />
<?php endif ?>
<!-- Custom Css PART2-->
    <style>
        .to {font-family: 'Times New Roman', Times, serif; font-size: 18px; color="#3465a4"; }
        .tp {font-weight: normal; font-size: 17px; }
        .ton {font-family: 'Times New Roman', Times, serif; font-size: 16px; font-weight: bold;}

        * {
            font-family: Comfortaa, serif;
            /*font-weight: normal;*/
            /*font-size: 1.04em;*/
        }

        /*.sidebar {*/
        /*    width: 240px;*/
        /*}*/
        /*section.content {*/
        /*    margin: 100px 2px 0px 240px;*/
        /*    -moz-transition: 0.5s;*/
        /*    -o-transition: 0.5s;*/
        /*    -webkit-transition: 0.5s;*/
        /*    transition: 0.5s;*/
        /*}*/

        .com {
            font-family: Comfortaa, serif !important;
            letter-spacing: 0.7px !important;
        }

        .f_robo {
            font-family: Roboto, sans-serif, Arial, Verdana !important;
            font-size: 16px;
            letter-spacing: 0.7px !important;
        }

        .f_ice {
            font-family: Iceland, sans-serif;
            letter-spacing: 0.7px !important;
        }

        /*.f_quicks {*/
        /*    font-family: Quicksand, sans-serif;*/
        /*    letter-spacing: 0.7px !important;*/
        /*}*/

        /*.f_lora {*/
        /*     font-family: Lora, sans-serif;*/
        /*     letter-spacing: 0.7px !important;*/
        /* }*/

        /*.f_jura {*/
        /*    font-family: Jura, sans-serif;*/
        /*    letter-spacing: 0.7px !important;*/
        /*}*/

        /*.f_opens {*/
        /*    font-family: "Open Sans", sans-serif;*/
        /*    letter-spacing: 0.7px !important;*/
        /*}*/

        /*.f_playf {*/
        /*    font-family: "Playfair Display", sans-serif;*/
        /*    letter-spacing: 0.7px !important;*/
        /*}*/

        /*.f_ralew {*/
        /*    font-family: Raleway, sans-serif;*/
        /*    letter-spacing: 0.7px !important;*/
        /*}*/

        .bo {
            font-weight: bold !important;
        }
        .boi {
            font-weight: bold !important;
            font-style: italic;
        }
    </style>

