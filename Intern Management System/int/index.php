<?php
/**
 * Created by PhpStorm.
 * User: Vijay Purohit
 * Date: 10-Jun-19
 * Time: 9:52 PM
 * Project: ims_vj
 */

$asset_path_link='../';     // to link the asset folder with current level.
$int_pages_link='';         // to link the pages in directory to the admin base level pages.
$bootstrap_select=1;

?>
<?php  require_once($asset_path_link.'config.php'); ?>
<?php  require_once (INT_PATH .'/_.php'); ?>

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
        $project_count = getAllOngoingProjectsCountOfUser('1',$user['uid']);
        $team_count = getAllOngoingTEAMSCountOfUser($today_date_normal, $user['uid']);
        ?>
        <div class="row clearfix">
            <!--            ongoing project-->
            <a href="project_ongoing.php">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
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
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
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
        </div>
        <!-- END FIRST ROW -->

        <!--        second row columns-->
        <div class="row clearfix">
            <!--            projects-->
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 " >
                <div class="card " >
                    <!--                <div class="header" style="background: #546e7a ">-->
                    <!--                    <h2 style="text-align: center; color: white">-->
                    <!--                        PROJECTS-->
                    <!--                    </h2>-->
                    <!--                </div>-->
                    <div class="body" style="overflow-y: scroll; height: 200px; background: #607d8b">
                        <div class="row clearfix">
                            <div class="col-md-12" >
                                <table class="table-bordered" width="100%" style="padding-top: 18px; line-height: 20px; letter-spacing: 0.1px; font-size: 14px; ">
                                    <thead>
                                    <tr>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php
                                    $ongoingProject = getAllOnGoingProjectOfUser(1, $user['uid']);
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
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 " >
                <div class="card " >
                    <!--                <div class="header" style="background: #d63b2f ">-->
                    <!--                    <h2 style="text-align: center; color: white">-->
                    <!--                        TEAMS-->
                    <!--                    </h2>-->
                    <!--                </div>-->
                    <div class="body" style="overflow-y: scroll; height: 200px; background: #f44336">
                        <div class="row clearfix">
                            <div class="col-md-12" >
                                <table class="table-bordered" width="100%" style="padding-top: 18px; line-height: 20px; letter-spacing: 0.1px; font-size: 14px; ">
                                    <thead>
                                    <tr>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php
                                    $ongoingTeams = getAllOnGoingTeamsOfUser($today_date_normal,$user['uid']);
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

        </div>
        <!--        end second row columns-->


        <!-- third ROW -->
        <?php
        require_once(INT_PATH . '/task_logics.php');
        $all_tasks = getAllTasksAccToStatusAndUser(tsk_enable,$userId);
        ?>
        <div class="row clearfix">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                <div class="card " >
                    <div class="header"">
                    <h2>
                        Pending Tasks
                    </h2>
                </div>
                <div class="body" >
                    <div class="table-responsive" style="position: center; overflow-y: scroll; ">
                        <table  class="table table-condensed table-bordered table-striped table-hover" >
                            <thead>
                            <tr style="font-weight: bold; background: #009688; color: white; ">
                                <th>TITLE</th>
                                <th>DEADLINE</th>
                                <th>PROJECT</th>
                                <th>AT</th>
                                <th>STATUS</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr style="font-weight: bold; background: #009688; color: white;">
                                <th>TITLE</th>
                                <th>DEADLINE</th>
                                <th>PROJECT</th>
                                <th>AT</th>
                                <th>STATUS</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <?php

                            foreach ($all_tasks as $at) {

                                $date_addD = new DateTime($at['created_at']);
                                $date_add_formatted_date = $date_addD->format('M, d Y');
                                $date_add_formatted_time = $date_addD->format('h:i A');

                                $tkid = $at['tkid'];
                                $intern_id = $at['intern_id'];
                                $from_id = $at['from_id'];
                                $title_ = $at['title_'];
                                $desc_= $at['desc_'];
                                $project_id= $at['project_id'];
                                $project_name= $at['project_name'];
                                $deadline= $at['deadline'];
                                $notify= $at['notify'];
                                $intern_name= $at['intern_name'];
                                $created_by_name= $at['created_by_name'];

                                $approved_string = $notify == 1 ? 'NOT SEEN' : 'SEEN';
                                $notify_string_color = $notify == tsk_inspection ? 'col-red' : ($notify == tsk_inspectionViewed ? 'col-green' : 'col-yellow');


                                $deadlineD = new DateTime($deadline);
                                $deadlineD_formatted_date = $deadlineD->format('M, d Y');


                                $c_status_color = 'blue';
                                if ($at['status'] == tsk_enable) {
                                    $c_status_color = 'col-orange';
                                    $string_s = 'PENDING';
                                } else if ($at['status'] == tsk_disable ) {
                                    $c_status_color = 'col-red';
                                    $string_s = 'DISMISSED';
                                }else if ($at['status'] == tsk_completed ) {
                                    $c_status_color = 'col-green';
                                    $string_s = 'COMPLETED';
                                }

                                $url_page ="task_show.php?tkid=$tkid";

                                echo "<tr>";

                                echo "<td class='$notify_string_color' style='font-weight: bold; '> ";
                                echo "<a href='$url_page' target='_blank' style='color: inherit'>";
                                echo $title_;
                                echo "</a>";
                                echo "</td>";

                                echo "<td>";
                                    echo $deadlineD_formatted_date;
                                echo "</td>";

                                echo "<td style='color: blueviolet; font-weight: bold' >";
                                    echo $project_name;

                                echo "</td>";



                                echo "<td >";
                                    echo $date_add_formatted_date . " | " . $date_add_formatted_time;
                                echo "</td>";
                                echo "<td class='$c_status_color' style='text-align: center; font-weight: bold;;'>";
                                    echo $string_s;
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
    <!-- END third ROW -->
    </div>
</section>
<!-- -----------------------------------------HTML FOOTER--------------------------------------------------------------- -->
<?php require_once (INCLUDE_PATH .'/layouts/_footer.php'); ?>

<!-- Custom Js -->
<!-- Jquery CountTo Plugin Js -->
<script src="<?php echo $asset_path_link ?>assets/bsb/plugins/jquery-countto/jquery.countTo.js"></script>
<script src="<?php echo $asset_path_link ?>assets/bsb/js/pages/index.js"></script>

<!--// Showing Notifications-->
<?php if(isset($_SESSION['greetings'])):
    $greet = $_SESSION['greetings'].", ".ucwords($user['full_name']);
    ?>
    <script>
        $(function () {
            showNotification('alert-success', <?php echo "'".$greet."'" ?>, 'top', 'right', 'animated rotateInUpRight', 'animated rotateOutUpRight');
        });
    </script>
    <?php unset($_SESSION['greetings']) ?>
<?php endif ?>
<!-- ------------------------------------------END HTML FOOTER --------------------------------------------------------------- -->
</html>
