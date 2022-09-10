<?php
/**
 * Created by PhpStorm.
 * User: Vijay Purohit
 * Date: 12-Jun-19
 * Time: 11:34 AM
 * Project: ims_vj
 */

$asset_path_link='../';     // to link the asset folder with current level.
$int_pages_link='';         // to link the pages in directory to the admin base level pages.
//$bootstrap_select=1;
?>
<?php  require_once($asset_path_link.'config.php'); ?>
<?php  require_once (INT_PATH .'/_.php'); ?>

<section class="content">
    <?php  include(INCLUDE_PATH . '/layouts/_messages.php'); ?>
    <div class="container-fluid">

    <!-- SECOND ROW -->
    <?php
    $projects = getParticularUserOnGoingBatchTeamsProject($today_date_normal, $user['uid']);
    ?>
    <div class="row clearfix">
        <div class="block-header">
            <h2 class="com bo"
                style="text-align: center; font-size: 20px; letter-spacing: 2px; padding-bottom: 5px;">
                PROJECTS
            </h2>
        </div>
        <!-- CURRENT PROJECTS -->
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <div class="card">
                <div class="body bg-teal">
                    <div class="font-bold m-b--35">CURRENT PROJECTS</div>
                    <ul class="dashboard-stat-list">
                        <?php
                        foreach ($projects as $pj):
                            ?>
                            <li>
                                <b><?php echo ucwords($pj['project_name']);?></b>
                                <?php echo " { ".$pj['team_name']." }";?>
                                <span class="pull-right"><b><?php echo $pj['num_members'];?></b> <small>MEMEBERS</small></span>
                            </li>
                        <?php
                        endforeach;
                        ?>

                    </ul>
                </div>
            </div>
        </div>
        <!-- #END# CURRENT PROJECTS -->
    </div>
    <!-- END SECOND ROW -->
    <!-- THIRD ROW -->
    <?php
    $teams = getParticularUserOngoingBatchTeams($today_date_normal, $user['uid']);
    ?>
    <div class="row clearfix">
        <div class="block-header">
            <h2 class="com bo"
                style="text-align: center; font-size: 20px; letter-spacing: 2px; padding-bottom: 5px;">
                TEAMS
            </h2>
        </div>
        <!-- CURRENT TEAMS -->
        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
            <div class="card">
                <div class="header">
                    <h2>CURRENT TEAMS</h2>
                    <!--                            <ul class="header-dropdown m-r--5">-->
                    <!--                                <li class="dropdown">-->
                    <!--                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">-->
                    <!--                                        <i class="material-icons">more_vert</i>-->
                    <!--                                    </a>-->
                    <!--                                    <ul class="dropdown-menu pull-right">-->
                    <!--                                        <li><a href="javascript:void(0);">Action</a></li>-->
                    <!--                                        <li><a href="javascript:void(0);">Another action</a></li>-->
                    <!--                                        <li><a href="javascript:void(0);">Something else here</a></li>-->
                    <!--                                    </ul>-->
                    <!--                                </li>-->
                    <!--                            </ul>-->
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-hover dashboard-task-infos">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Batch</th>
                                <th>Team</th>
                                <th>#Project</th>
                                <th>#Members</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i=1;
                            foreach ($teams as $tm):
                                ?>
                                <tr>
                                    <td><?php echo $i;?></td>
                                    <td><?php echo $tm['batch_name']." ( ".$tm['batch_year'].")";?></td>
                                    <td><?php echo $tm['team_name']." (# ". $tm['num_members']." )";?></td>
                                    <td><?php echo $tm['current_proj'];?></td>
                                    <?php
                                        $tm_members = getAllTeamMembers($tm['tid']);
                                    ?>
                                    <td><?php foreach ($tm_members as $tmb){
                                        echo $tmb['full_name'].", ";
                                        }?></td>
                                </tr>
                                <?php
                                $i++;
                            endforeach;
                            ?>
                            <!--                                    <tr>-->
                            <!--                                        <td>2</td>-->
                            <!--                                        <td>Task B</td>-->
                            <!--                                        <td><span class="label bg-blue">To Do</span></td>-->
                            <!--                                        <td>John Doe</td>-->
                            <!--                                        <td>-->
                            <!--                                            <div class="progress">-->
                            <!--                                                <div class="progress-bar bg-blue" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%"></div>-->
                            <!--                                            </div>-->
                            <!--                                        </td>-->
                            <!--                                    </tr>-->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# CURRENT TEAMS -->
    </div>
    <!-- END THIRD ROW -->
    </div>
</section>

<!-- -----------------------------------------HTML FOOTER--------------------------------------------------------------- -->
<?php require_once (INCLUDE_PATH .'/layouts/_footer.php'); ?>

<!-- Custom Js -->

<!-- ------------------------------------------END HTML FOOTER --------------------------------------------------------------- -->
</html>
