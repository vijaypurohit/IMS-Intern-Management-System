<?php
/**
 * Created by PhpStorm.
 * User: Vijay Purohit
 * Date: 18-Jun-19
 * Time: 5:24 PM
 * Project: ims_vj
 */
// intern leave individual report
$asset_path_link='../';
require_once($asset_path_link.'config.php');
require_once('_sessions.php');
require_once(INCLUDE_PATH . "/logic/common_functions.php");

$user_s = $_SESSION['user'];
$userId = $user_s['id'];

if(isset($_REQUEST['leave_id'])){
    $leave_id = $_REQUEST['leave_id'];
}
$my_leave = getUserLeaveDetailsForPrint($leave_id);
//var_dump($my_leave);
?>
<HTML>
<HEAD>
    <META http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <META http-equiv="X-UA-Compatible" content="IE=8">
    <TITLE>LEAVE FORM - <?php echo APP_TITLE ?>
    </TITLE>
    <!-- Favicon-->
    <link rel="icon" href="<?php echo $asset_path_link; ?>assets/favicon.ico" type="image/x-icon">
    <link href="<?php echo $asset_path_link; ?>assets/css/font_roboto.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $asset_path_link; ?>assets/css/font_iceland.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $asset_path_link; ?>assets/css/font_comfortaa.css" rel="stylesheet" type="text/css">
    <!-- Bootstrap Core Css -->
    <link href="<?php echo $asset_path_link; ?>assets/bsb/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
    <!-- Custom Css PART2-->
    <style>
        * {
            font-family: Comfortaa, serif;
            /*font-weight: normal;*/
            /*font-size: 1.04em;*/
        }

        .com {
            font-family: Comfortaa, serif !important;
            letter-spacing: 0.7px !important;
        }

        .bo {
            font-weight: bold !important;
        }
    </style>


    <style type="text/css" media="print">
        @page {
            size: auto;   /* auto is the initial value */
            margin: 0;  /* this affects the margin in the printer settings */
            font-size: inherit;
        }

        @media print {
            .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12 {
                float: left;
            }

            .col-sm-12 {
                width: 100%;
            }

            .col-sm-11 {
                width: 91.66666667%;
            }

            .col-sm-10 {
                width: 83.33333333%;
            }

            .col-sm-9 {
                width: 75%;
            }

            .col-sm-8 {
                width: 66.66666667%;
            }

            .col-sm-7 {
                width: 58.33333333%;
            }

            .col-sm-6 {
                width: 50%;
            }

            .col-sm-5 {
                width: 41.66666667%;
            }

            .col-sm-4 {
                width: 33.33333333%;
            }

            .col-sm-3 {
                width: 25%;
            }

            * {
                font-family: Comfortaa, serif;
                /*font-weight: normal;*/
                /*font-size: 1.04em;*/
            }

            .com {
                font-family: Comfortaa, serif !important;
                letter-spacing: 0.7px !important;
            }

            .bo {
                font-weight: bold !important;
            }
            .row {
                margin-right: -15px;
                margin-left: -15px;
            }
            .form-group {
                width: 100%;
                margin-bottom: 0px;
                font-size: inherit;
            }

            /*html { margin-top: 20px;*/
            /*margin-left: 20px;*/
            /*margin-right: 20px;}*/

        }
    </style>

</HEAD>
<BODY>
<div class="container">
    <div class="block-header">
        <h2 class="com bo"
            style="text-align: center; font-size: 20px; letter-spacing: 2px; padding-bottom: 3px;">
            LEAVE REQUEST FORM
        </h2>
    </div>
    <div class="row clearfix" style="color: #000; font-size: 14px; padding-left: 10%; ">
        <div class="col-xs-12 col-sm-12 col-md-12" style="border-style: ridge; border-radius: 5px; width: 85%">
        <div class="col-xs-12 col-sm-12 col-md-12" style="padding-top: 25px">
            <div class="form-group">
                <label>  DATE :  </label>
                <?php
                $date_addD = new DateTime($my_leave['date_add']);
                $date_add_formatted_date = $date_addD->format('M, d Y');
                $date_add_formatted_time = $date_addD->format('h:i A');
                echo $date_add_formatted_date . " | " . $date_add_formatted_time;
                ?>
            </div>
        </div>

        <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="form-group">
                <label>   FROM  :  </label>
                <?php
                $from_ldateD = new DateTime($my_leave['from_ldate']);
                $from_ldate_formatted_date = $from_ldateD->format('M, d Y');
                echo $from_ldate_formatted_date ;
                ?>
                </div>
        </div>
            <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                    <label>   TO  :  </label>
                    <?php
                    $to_ldateD = new DateTime($my_leave['to_ldate']);
                    $to_ldate_formatted_date = $to_ldateD->format('M, d Y');

                    $interval = $from_ldateD->diff($to_ldateD);
                    $noOfD =  $interval->format('%d');
                    $noOfD =  (int)$noOfD+1;
                    $date_str =  $noOfD>1?'days':'day';

                    echo $to_ldate_formatted_date." ( ".$noOfD." ".$date_str." )" ;
                    ?>      </div>
            </div>
        <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="form-group">
                <label>   STUDNET NAME  :  </label>
                <?php echo $my_leave['intern_name']; ?>       </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="form-group">
                <label>FATHER NAME   :  </label>
<!--                --><?php //echo $my_leave['father_name']; ?>
            </div>
        </div>
<!--        <div class="col-xs-12 col-sm-6 col-md-6">-->
<!--            <div class="form-group">-->
<!--                <label>TECHNOLOGY   :  </label>-->
<!--                --><?php //echo ''; ?>
<!--            </div>-->
<!--        </div>-->

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label>BATCH :  </label>
                <?php
                $batch_name="Not in a Batch";
                $batch_year="";
                $formatted_date_f="";
                $formatted_date_t="";
                $noOfD="";
                if($my_leave['batch_name']!=NULL){
                    $batch_name = $my_leave['batch_name'];
                    $batch_year = $my_leave['batch_year'];
                    $df = new DateTime($my_leave['from_d_b']);
                    $formatted_date_f = $df->format('M, d Y');
                    $formatted_date_f_normal = $df->format('d-m-Y');

                    $dt = new DateTime($my_leave['to_d_b']);
                    $formatted_date_t = $dt->format('M, d Y');
                    $formatted_date_t_normal = $dt->format('d-m-Y');

                    $interval = $df->diff($dt);
                    $noOfD =  $interval->format('%m months, %R%d days');
                }
                ?>
                <?php echo $my_leave['batch_name']." ( ".$my_leave['batch_year'].") ".$formatted_date_f." - ".$formatted_date_t." ( ".$noOfD." )"; ?>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
                <HR style="padding-top: 0px; border: 1px solid grey">
        </div>

        <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="form-group">
                <label>REASON :  </label>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
<!--            <textarea disabled style="height:60px;" id="leave_reason" onkeyup="countChar(this)" class="form-control" >--><?php //echo $my_leave['reason']; ?><!--</textarea>-->
            <blockquote class="m-b-25">
                <p style="font-size: 80%"><?php echo $my_leave['reason']; ?></p>
            </blockquote>

        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <p CLASS="help-block"  style="font-size: 90%">Learning loss of classes will be bear on your own Risk & Responsibility.</p>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <HR style="padding-top: 0px; border: 1px solid grey">
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="form-group">
                <label>FACULTY NAME :  </label>
                <?php echo $my_leave['approved_by_name']; ?>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="form-group">
                <label>DATE :  </label>
                <?php
                $date_addD = new DateTime($my_leave['approved_time']);
                $date_add_formatted_date = $date_addD->format('M, d Y');
                $date_add_formatted_time = $date_addD->format('h:i A');
                echo $date_add_formatted_date . " | " . $date_add_formatted_time;
                ?>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label>FACULTY SIGNATURE :  </label>
                <?php $fac_sign =  $my_leave['approved_by_sign'];

                ?>
                <img src="<?php echo UPLOAD_URL.$upload_sign_fol_name.$fac_sign; ?>" width="150" height="50" alt="Faculty Signature" />
            </div>
        </div>


<!--        <div class="col-xs-12 col-sm-6 col-md-6">-->
<!--            <div class="form-group">-->
<!--                <label>HR SIGNATURE :  </label>-->
<!--                IMG-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="col-xs-12 col-sm-6 col-md-6">-->
<!--            <div class="form-group">-->
<!--                <label>DATE :  </label>-->
<!--                    --><?php
//                        $date_addD = new DateTime($my_leave['approved_time']);
//                        $date_add_formatted_date = $date_addD->format('M, d Y');
//                        $date_add_formatted_time = $date_addD->format('h:i A');
//                        echo $date_add_formatted_date . " | " . $date_add_formatted_time;
//                    ?>
<!--            </div>-->
<!--        </div>-->
        <div class="col-xs-12 col-sm-12 col-md-12">
            <p CLASS="help-block" style="font-size: 90%" >I understand that until both my Faculty or the HR sign this form, my leave is not approved.</p>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12" style="padding-bottom: 5px">
            <div class="form-group">
                <br>
                <label>STUDENT'S SIGNATURE : </label>

                <?php $int_sign =  $my_leave['intern_sign']; ?>
                <img src="<?php echo UPLOAD_URL.$upload_sign_fol_name.$int_sign; ?>" width="150" height="50" alt="Intern Signature" />
            </div>

        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <p class="help-block"  style="font-size: 70%;text-align: right" >* This is erp generated form *</p>
        </div>
            <?php
            $approved_status = $my_leave['approved'];
            $approved_string = $approved_status == 1 ? 'APPROVED' : ($approved_status == -1 ? 'REJECTED' : 'PENDING');
            $approved_status_color = $approved_status == 1 ? 'limegreen' : ($approved_status == -1 ? 'orangered' : 'orange');
            ?>
            <div class="col-xs-12 col-sm-12 col-md-12 ">
                <p style="font-size: 70%;text-align: center;background: <?php echo $approved_status_color; ?> ; color: white; font-weight: bold" ><?php echo $approved_string; ?></p>
            </div>
        </div>

    </div>

</div>

</BODY>
<br>
<br>
<!-- Jquery Core Js -->
<script src="<?php echo $asset_path_link; ?>assets/bsb/plugins/jquery/jquery.min.js"></script>

<!-- Bootstrap Core Js -->
<script src="<?php echo $asset_path_link; ?>assets/bsb/plugins/bootstrap/js/bootstrap.js"></script>
</HTML>

