<?php
/**
 * Created by PhpStorm.
 * User: vijay
 * Date: 5/21/2019
 * Time: 12:07 PM
 * Project: ims_vj
 * File : index.php
 */

$asset_path_link='../';     // to link the asset folder with current level.
$adm_pages_link='';         // to link the pages in directory to the admin base level pages.

?>
<?php  require_once($asset_path_link.'config.php'); ?>
<?php  require_once (ADM_PATH .'/_.php'); ?>

<section class="content">
        <?php  include(INCLUDE_PATH . '/layouts/_messages.php'); ?>
    <div class="container-fluid">
        <div class="block-header">
            <h2>DASHBOARD</h2>
        </div>
        <!-- FIRST ROW -->
        <?php
        global $today_date_normal;
//        $today_date_normal='2019-06-30';
        $batch_count = getAllOngoingBatchesCount($today_date_normal);
        $project_count = getAllOngoingProjectsCount('1');
        $team_count = getAllOngoingTEAMSCount($today_date_normal);
        $intern_count = getAllOngoingBatchesInternsCount($today_date_normal);
        ?>
        <div class="row clearfix">
<!--            Ongoing Batch-->
            <a href="batch_ongoing_batches.php" >
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 ">
                    <div class="info-box bg-brown hover-zoom-effect">
                        <div class="icon">
                            <i class="material-icons">streetview</i>
                        </div>
                        <div class="content">
                            <div class="text">ONGOING BATCHES</div>
                            <div class="number count-to" data-from="0" data-to="<?php echo $batch_count['ongoing_batch_count']?>" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
            </a>
<!--            ongoing project-->
            <a href="project_ongoing.php">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-blue-grey hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">android</i>
                        </div>
                        <div class="content">
                            <div class="text">ONGOING PROJECTS</div>
                            <div class="number count-to" data-from="0" data-to="<?php echo $project_count['ongoing_project_count']?>" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
            </a>
<!--            ongoing team-->
            <a href="team_ongoing.php">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-red hover-zoom-effect">
                        <div class="icon">
                            <i class="material-icons">rowing</i>
                        </div>
                        <div class="content">
                            <div class="text">ONGOING TEAMS</div>
                            <div class="number count-to" data-from="0" data-to="<?php echo $team_count['ongoing_team_count']?>" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
            </a>
<!--            batch interns-->
            <a href="batch_interns_list.php">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-orange hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">person_add</i>
                        </div>
                        <div class="content">
                            <div class="text">BATCH INTERNS</div>
                            <div class="number count-to" data-from="0" data-to="<?php echo $intern_count['ongoing_inter_count']?>" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <!-- END FIRST ROW -->

        <!--        second row columns-->

        <div class="row clearfix">
<!--            batches-->
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 " >
            <div class="card " >
                <!--                <div class="header" style="background: #6a4b3f ">-->
                <!--                    <h2 style="text-align: center; color: white">-->
                <!--                        BATCHES-->
                <!--                    </h2>-->
                <!--                </div>-->
                <div class="body" style="overflow-y: scroll; height: 350px; background: #795548">
                    <div class="row clearfix">
                        <div class="col-md-12" >
                            <table class="table-bordered" width="100%" style="padding-top: 18px; line-height: 20px; letter-spacing: 0.1px; font-size: 14px; ">
                                <thead>
                                <tr>
                                </tr>
                                </thead>
                                <tbody>

                                <?php

                                $ongoingBatches = getAllOngoingBatches($today_date_normal);
                                foreach ($ongoingBatches as $ob ) {
                                    echo "<tr>";
                                    echo "<td>";
                                    echo "<a href='batch_ind_home.php?bid=$ob[bid]' target='_blank' style='letter-spacing: 2px; color: ghostwhite; font-weight: bold;'>";
                                    echo $ob['batch_name']." (".$ob['batch_year'].") ";
                                    echo "</a>";
                                    echo "</td>";

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
<!--            projects-->
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 " >
            <div class="card " >
<!--                <div class="header" style="background: #546e7a ">-->
<!--                    <h2 style="text-align: center; color: white">-->
<!--                        PROJECTS-->
<!--                    </h2>-->
<!--                </div>-->
                <div class="body" style="overflow-y: scroll; height: 350px; background: #607d8b">
                    <div class="row clearfix">
                        <div class="col-md-12" >
                            <table class="table-bordered" width="100%" style="padding-top: 18px; line-height: 20px; letter-spacing: 0.1px; font-size: 14px; ">
                                <thead>
                                <tr>
                                </tr>
                                </thead>
                                <tbody>

                                <?php
                                $ongoingProject = getAllOnGoingProject(1);
                                foreach ($ongoingProject as $pjT ) {
                                    echo "<tr>";
                                    echo "<td>";
                                    echo "<a href='project_ind_home.php?pid=$pjT[pid]' target='_blank' style='letter-spacing: 2px; color: ghostwhite; font-weight: bold;'>";
                                    echo $pjT['project_name']." (".$pjT['batch_year'].") ";
                                    echo "</a>";
                                    echo "</td>";

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
<!--            teams-->
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 " >
            <div class="card " >
<!--                <div class="header" style="background: #d63b2f ">-->
<!--                    <h2 style="text-align: center; color: white">-->
<!--                        TEAMS-->
<!--                    </h2>-->
<!--                </div>-->
                <div class="body" style="overflow-y: scroll; height: 350px; background: #f44336">
                    <div class="row clearfix">
                        <div class="col-md-12" >
                            <table class="table-bordered" width="100%" style="padding-top: 18px; line-height: 20px; letter-spacing: 0.1px; font-size: 14px; ">
                                <thead>
                                <tr>
                                </tr>
                                </thead>
                                <tbody>

                                <?php
                                $ongoingTeams = getAllOnGoingTeams($today_date_normal);
                                foreach ($ongoingTeams as $tm ) {
                                    echo "<tr>";
                                    echo "<td>";
                                    echo "<a href='team_ind_home.php?tid=$tm[tid]' target='_blank' style='letter-spacing: 2px; color: ghostwhite; font-weight: bold;'>";
                                    echo $tm['team_name'];
                                    echo "</a>";
                                    echo "</td>";

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
<!--            interns-->
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 " >
            <div class="card " >
<!--                <div class="header" style="background: #e08600 ">-->
<!--                    <h2 style="text-align: center; color: white">-->
<!--                        INTERNS-->
<!--                    </h2>-->
<!--                </div>-->
                <div class="body" style="overflow-y: scroll; height: 350px; background: #ff9800">
                    <div class="row clearfix">
                        <div class="col-md-12" >
                            <table class="table-bordered" width="100%" style="padding-top: 18px; line-height: 20px; letter-spacing: 0.1px; font-size: 14px; ">
                                <thead>
                                <tr>
                                </tr>
                                </thead>
                                <tbody>

                                <?php
                                $ongoingBatchInterns = getAllOngoingBatchesInternsList($today_date_normal);
                                foreach ($ongoingBatchInterns as $obi ) {
                                    echo "<tr>";
                                    echo "<td>";
                                    echo "<a href='users/user_profile_view.php?uid=$obi[uid]' target='_blank' style='letter-spacing: 2px; color: ghostwhite; font-weight: bold;'>";
                                    echo $obi['full_name'];
                                    echo "</a>";
                                    echo "</td>";

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
        </div>
        <!--        end second row columns-->

        <!-- third ROW -->
        <?php
        $today_leaves = getAllUsersLeavesOnToday($today_date_normal);
        $upcoming_leaves = getAllUsersLeavesOnTodayAndUpcoming($today_date_normal);
        if(count($today_leaves)|| count($upcoming_leaves)):
        ?>
                <div class="row clearfix">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                        <div class="card " >
                            <div class="header"">
                            <h2>
                                On Leave
                            </h2>
                        </div>
                        <div class="body" >
                            <div class="table-responsive" style="position: center; overflow-y: scroll; ">
                                <table  class="table table-condensed table-bordered table-striped table-hover" >
                                    <thead>
                                    <tr style="font-weight: bold; background: #009688; color: white; ">
                                        <th>Initiated</th>
                                        <th>Date (f-t)</th>
                                        <th>NAME</th>
                                        <th>STATUS</th>
                                        <th>BY</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr style="font-weight: bold; background: #009688; color: white;">
                                        <th>Initiated</th>
                                        <th>Date (f-t)</th>
                                        <th>NAME</th>
                                        <th>STATUS</th>
                                        <th>BY</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php
                                    if(count($today_leaves)){
                                        echo "<tr>";
                                        echo "<td colspan='5' style='text-align: center; font-weight: bold; color: silver;'>";
                                        echo "TODAY";
                                        echo "</td>";
                                        echo "</tr>";
                                    }

                                    foreach ($today_leaves as $tl) {

                                        $date_addD = new DateTime($tl['date_add']);
                                        $date_add_formatted_date = $date_addD->format('M, d Y');
                                        $date_add_formatted_time = $date_addD->format('h:i A');

                                        $from_ldateD = new DateTime($tl['from_ldate']);
                                        $from_ldate_formatted_date = $from_ldateD->format('M, d');

                                        $to_ldateD = new DateTime($tl['to_ldate']);
                                        $to_ldate_formatted_date = $to_ldateD->format('M, d');

                                        $interval = $from_ldateD->diff($to_ldateD);
                                        $noOfD =  $interval->format('%d');
                                        $noOfD =  (int)$noOfD+1;
                                        $date_str =  $noOfD>1?'days':'day';

                                        $approved_status = $tl['approved'];
                                        $approved_by_name= $tl['approved_by_name'];
                                        $leave_user_name= $tl['leave_user_name'];
                                        $reason= $tl['reason'];

                                        $approved_string = $approved_status == 1 ? 'APPROVED' : ($approved_status == -1 ? 'REJECTED' : 'PENDING');
                                        $approved_status_color = $approved_status == 1 ? 'col-green' : ($approved_status == -1 ? 'col-red' : 'col-orange');

                                        if($approved_by_name != null){
        //            $approved_by_name = $approved_by_name;
                                            $approved_timeD = new DateTime($tl['approved_time']);
                                            $approved_timeD_formatted_date = $approved_timeD->format('M, d Y');
                                            $approved_timeD_formatted_time = $approved_timeD->format('h:i A');
                                            $le_approved_name = $approved_by_name."<br>".$approved_timeD_formatted_date . " | " . $approved_timeD_formatted_time;
                                        }else{
                                            $approved_timeD_formatted_date = '';
                                            $approved_timeD_formatted_time = '';
                                            $le_approved_name = 'NO-ONE';
                                        }

                                        echo "<tr>";
                                        echo "<td>";
                                        echo $date_add_formatted_date . " | " . $date_add_formatted_time;
                                        echo "</td>";

                                        echo "<td>";
                                        echo $from_ldate_formatted_date . " - " . $to_ldate_formatted_date." ( ".$noOfD." ".$date_str." )" ;
                                        echo "</td>";

                                        echo "<td style='color: blueviolet; font-weight: bold' >";
                                        echo "<a href='users/user_profile_view.php?uid=$tl[user_id]' target='_blank' style='color: inherit'>";
                                        echo $tl['leave_user_name'];
                                        echo "</a>";
                                        echo "</td>";



                                        echo "<td class='$approved_status_color' style='text-align: center; font-weight: bold;;'>";
                                        echo $approved_string;
                                        echo "</td>";
                                        echo "<td>";
                                        echo $le_approved_name;
                                        echo "</td>";
                                        echo "</tr>";

                                    }

                                    if(count($upcoming_leaves)){

                                        echo "<tr>";
                                        echo "<td colspan='5' style='text-align: center; font-weight: bold; color: silver;'>";
                                        echo "UPCOMING";
                                        echo "</td>";
                                        echo "</tr>";

                                        foreach ($upcoming_leaves as $tl) {

                                            $date_addD = new DateTime($tl['date_add']);
                                            $date_add_formatted_date = $date_addD->format('M, d Y');
                                            $date_add_formatted_time = $date_addD->format('h:i A');

                                            $from_ldateD = new DateTime($tl['from_ldate']);
                                            $from_ldate_formatted_date = $from_ldateD->format('M, d');

                                            $to_ldateD = new DateTime($tl['to_ldate']);
                                            $to_ldate_formatted_date = $to_ldateD->format('M, d');

                                            $interval = $from_ldateD->diff($to_ldateD);
                                            $noOfD =  $interval->format('%d');
                                            $noOfD =  (int)$noOfD+1;
                                            $date_str =  $noOfD>1?'days':'day';

                                            $approved_status = $tl['approved'];
                                            $approved_by_name= $tl['approved_by_name'];
                                            $leave_user_name= $tl['leave_user_name'];
                                            $reason= $tl['reason'];

                                            $approved_string = $approved_status == 1 ? 'APPROVED' : ($approved_status == -1 ? 'REJECTED' : 'PENDING');
                                            $approved_status_color = $approved_status == 1 ? 'col-green' : ($approved_status == -1 ? 'col-red' : 'col-orange');

                                            if($approved_by_name != null){
        //            $approved_by_name = $approved_by_name;
                                                $approved_timeD = new DateTime($tl['approved_time']);
                                                $approved_timeD_formatted_date = $approved_timeD->format('M, d Y');
                                                $approved_timeD_formatted_time = $approved_timeD->format('h:i A');
                                                $le_approved_name = $approved_by_name."<br>".$approved_timeD_formatted_date . " | " . $approved_timeD_formatted_time;
                                            }else{
                                                $approved_timeD_formatted_date = '';
                                                $approved_timeD_formatted_time = '';
                                                $le_approved_name = 'NO-ONE';
                                            }

                                            echo "<tr>";
                                            echo "<td>";
                                            echo $date_add_formatted_date . " | " . $date_add_formatted_time;
                                            echo "</td>";

                                            echo "<td>";
                                            echo $from_ldate_formatted_date . " - " . $to_ldate_formatted_date." ( ".$noOfD." ".$date_str." )" ;
                                            echo "</td>";

                                            echo "<td style='color: blueviolet; font-weight: bold' >";
                                            echo "<a href='users/user_profile_view.php?uid=$tl[user_id]' target='_blank' style='color: inherit'>";
                                            echo $tl['leave_user_name'];
                                            echo "</a>";
                                            echo "</td>";



                                            echo "<td class='$approved_status_color' style='text-align: center; font-weight: bold;;'>";
                                            echo $approved_string;
                                            echo "</td>";
                                            echo "<td>";
                                            echo $le_approved_name;
                                            echo "</td>";
                                            echo "</tr>";

                                        }
                                    }

                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php
        endif;
        ?>
    <!-- END third ROW -->
    </div>
</section>

<!-- ----------------------------------------- END HTML BODY ------------------------------------------------------------ -->

<!-- -----------------------------------------HTML FOOTER--------------------------------------------------------------- -->
    <?php require_once (INCLUDE_PATH .'/layouts/_footer.php'); ?>


    <!-- Custom Js -->
        <!-- Jquery CountTo Plugin Js -->
        <script src="<?php echo $asset_path_link ?>assets/bsb/plugins/jquery-countto/jquery.countTo.js"></script>
        <script src="<?php echo $asset_path_link ?>assets/bsb/js/pages/index.js"></script>
        <!-- Demo Js for skin color etc-->
<!--        <script src="--><?php //echo $asset_path_link ?><!--assets/bsb/js/demo.js"></script>-->


<!--// Showing Notifications-->
<?php if(isset($_SESSION['greetings'])):
    $greet = $_SESSION['greetings'].", ".ucwords($user['full_name']);
?>
        <script>
            $(function () {
                showNotification('alert-success', <?php echo "'".$greet."'" ?>, 'top', 'right', 'animated zoomInRight', 'animated zoomOutRight');
            });
        </script>
<?php unset($_SESSION['greetings']) ?>
<?php endif ?>
<!-- ------------------------------------------END HTML FOOTER --------------------------------------------------------------- -->
</html>