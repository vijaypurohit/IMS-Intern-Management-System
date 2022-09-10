<?php
/**
 * Created by PhpStorm.
 * User: Vijay Purohit
 * Date: 09-Jun-19
 * Time: 6:30 PM
 * Project: ims_vj
 */

$asset_path_link='../';
$adm_pages_link='';
$bootstrap_select=1;
$jqueryDataTable=1;
$dateTimePicker=1;

?>
<?php  require_once($asset_path_link.'config.php'); ?>
<?php  require_once (ADM_PATH .'/_.php'); ?>
<?php  require_once('intern_logic.php'); ?>
<?php
// For Double Submit of Form
$_SESSION['form_token'] = md5(session_id() . time() . $_SESSION['user']['id']);
?>
<style>
    table{
        margin: 0 auto;
        width: 100%;
        clear: both;
        border-collapse: collapse;
        table-layout: fixed;
        word-wrap:break-word;
    }
    /*table.dataTable tbody td {*/
    /*    white-space: nowrap;*/
    /*}*/
</style>

<section class="content">
    <?php  include(INCLUDE_PATH . '/layouts/_messages.php'); ?>
    <!-- LEAVE ACCEPT-->
    <?php
        $date_year_check = $today_date_year;
       $pending_leaves = getAllUsersLeavesPending($date_year_check);
    ?>
    <div class="container-fluid" style="padding-top: 25px">
        <div class="block-header">
            <h2 class="com bo"
                style="text-align: center; font-size: 20px; letter-spacing: 2px; padding-bottom: 5px;">
                MANAGE LEAVE
            </h2>
        </div>
        <!--  All Leaves -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            PENDING +<?php echo count($pending_leaves); ?>
                        </h2>
                    </div>
                    <!--                    <div class="col-sm-6"></div>-->
                    <div class="body" style="padding-top: 10px; overflow-y: scroll; height: 300px;">
                        <div class="table-responsive">
                            <table class="table-bordered" width="100%" style="padding-top: 20px; line-height: 30px; letter-spacing: 0.2px; font-size: 15px; ">
                                <thead>
                                <tr style="font-weight: bold; background: #607d8b; color: white">
                                    <th>INITIATED</th>
                                    <th>(f-t)</th>
                                    <th>USER</th>
                                    <th>REASON</th>
                                    <th>REACTION</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php

                                foreach ($pending_leaves as $ual ) {

                                    $date_addD = new DateTime($ual['date_add']);
                                    $date_add_formatted_date = $date_addD->format('M, d Y');
                                    $date_add_formatted_time = $date_addD->format('h:i A');

                                    $from_ldateD = new DateTime($ual['from_ldate']);
                                    $from_ldate_formatted_date = $from_ldateD->format('M, d');

                                    $to_ldateD = new DateTime($ual['to_ldate']);
                                    $to_ldate_formatted_date = $to_ldateD->format('M, d');

                                    $interval = $from_ldateD->diff($to_ldateD);
                                    $noOfD =  $interval->format('%d');
                                    $noOfD =  (int)$noOfD+1;
                                    $date_str =  $noOfD>1?'days':'day';

                                    $approved_status = $ual['approved'];
                                    $approved_by_name= $ual['approved_by_name'];
                                    $leave_user_name= $ual['leave_user_name'];
                                    $reason= $ual['reason'];

                                    echo "<tr>";
                                        echo "<td>";
                                            echo $date_add_formatted_date . " | " . $date_add_formatted_time;
                                        echo "</td>";
                                        echo "<td>";
                                            echo $from_ldate_formatted_date . " - " . $to_ldate_formatted_date." ( ".$noOfD." ".$date_str." )" ;
                                        echo "</td>";
                                        echo "<td style='font-weight: bold; color: blue'>" . $leave_user_name . "</td>";
                                        echo "<td>" . $reason."</td>";


                                    ?>
                                    <td>
                                        <?php if($ual['user_id'] != $user['uid']): ?>
                                        <form id="form_leave_approvals" action="intern_leave_accept.php" method="post">
                                            <input type="hidden" name="form_token" value="<?php echo $_SESSION['form_token'] ?>" />
                                            <input type="hidden" name="leave_id" value="<?php echo $ual['id'] ?>" />
                                            <input type="hidden" name="leave_approval" value="yes" />
                                            <button type='submit' name="leave_accepted" value="1" class='btn btn-block btn-success waves-effect'
                                                    style='font-size: 12px; font-weight: bold; letter-spacing: 1px;'>
                                                <i class="material-icons"> check </i></button>
                                            <button type='submit' name="leave_rejected" value="-1" class='btn btn-block btn-danger waves-effect'
                                                    style='font-size: 12px; font-weight: bold; letter-spacing: 1px;'>
                                                <i class="material-icons"> close </i></button>
                                        </form>
                                        <?php endif; ?>
                                    </td>

                                <?php
                                    echo "</tr>";
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- #END#  All Leaves -->
    </div>
    <!-- #END# LEAVE ACCEPT-->

</section>

<!-- ----------------------------------------- END HTML BODY ------------------------------------------------------------ -->

<!-- ----------------------------------------- HTML FOOTER --------------------------------------------------------------- -->
<?php require_once (INCLUDE_PATH .'/layouts/_footer.php'); ?>
<!-- Custom Js -->
<!-- Demo Js for skin color etc-->
<!--<script src="--><?php //echo $asset_path_link ?><!--assets/bsb/js/demo.js"></script>-->

<!-- ------------------------------------------END HTML FOOTER --------------------------------------------------------------- -->
</html>
