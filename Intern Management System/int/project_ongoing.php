<?php
/**
 * Created by PhpStorm.
 * User: Vijay Purohit
 * Date: 27-Jun-19
 * Time: 9:11 AM
 * Project: ims_vj
 */


$asset_path_link='../';
$int_pages_link='';
?>

<?php  require_once($asset_path_link.'config.php'); ?>
<?php  require_once (INT_PATH .'/_.php'); ?>
<?php // require_once('batch_logics.php'); ?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2 class="com bo"
                style="text-align: center; font-size: 20px; letter-spacing: 2px; padding-bottom: 5px;">
                ONGOING PROJECTS
            </h2>
        </div>
        <?php  include(INCLUDE_PATH . '/layouts/_messages.php'); ?>
        <!-- FIRST ROW -->
        <div class="row clearfix">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                <div class="card " >

                    <div class="body" >
                        <div class="table-responsive" style="position: center; overflow-y: scroll; ">
                            <table  class="table table-condensed table-bordered table-striped table-hover" >
                                <thead>
                                <tr style="font-weight: bold; background: #607d8b; color: white; ">
                                    <th>PROJECT NAME</th>
                                    <th>TEAM</th>
                                    <th data-toggle="tooltip" data-placement="top" title="number of members" >#</th>
                                    <th>CREATED AT</th>
                                    <th>BATCH</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr style="font-weight: bold; background: #607d8b; color: white; table-layout: fixed">
                                    <th>PROJECT NAME</th>
                                    <th>TEAM</th>
                                    <th data-toggle="tooltip" data-placement="bottom" title="number of members">#</th>
                                    <th>CREATED AT</th>
                                    <th>BATCH</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                <?php
                                $ongoingProject = getAllOnGoingProjectOfUser(1, $user['uid']);
                                foreach ($ongoingProject as $pj) {

                                    $d = new DateTime($pj['project_timestamp']);
                                    $formatted_date = $d->format('M, d Y');
                                    $formatted_time = $d->format('h:i A');

                                    $df = new DateTime($pj['from_d_b']);
                                    $formatted_date_f = $df->format('M, d Y');
                                    $formatted_date_f_normal = $df->format('d-m-Y');
                                    $dt = new DateTime($pj['to_d_b']);
                                    $formatted_date_t = $dt->format('M, d Y');
                                    $formatted_date_t_normal = $dt->format('d-m-Y');
                                    $interval = $df->diff($dt);
                                    $noOfD =  $interval->format('%m months, %R%d days');

                                    echo "<tr>";

                                    echo "<td style='color: red' >";
                                    echo "<a href='project_ind_home.php?pid=$pj[pid]' target='_blank' style='color: inherit'>";
                                    echo $pj['project_name']." (".$pj['batch_year'].") ";
                                    echo "</a>";
                                    echo "</td>";

                                    echo "<td>";
                                    echo $pj['team_name'];
                                    echo "</td>";
                                    echo "<td>";
                                    echo $pj['num_members'];
                                    echo "</td>";
                                    echo "<td>";
                                    echo $formatted_date . " <br> " . $formatted_time ;;
                                    echo "</td>";
//                                    echo "</tr>";

//                                    echo "<tr>";
                                    echo "<td style='text-align: center; font-weight: bold; color: blueviolet;'>";
                                    echo $pj['batch_name']." (".$pj['batch_year'].") ".$formatted_date_f." - ".$formatted_date_t." (".$noOfD.")";
                                    echo "</td>";
                                    echo "</tr>";


//                                    endif;
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END FIRST ROW -->
    </div>
</section>
<!-- ----------------------------------------- END HTML BODY ------------------------------------------------------------ -->

<!-- ----------------------------------------- HTML FOOTER --------------------------------------------------------------- -->
<?php require_once (INCLUDE_PATH .'/layouts/_footer.php'); ?>
<!-- Custom Js -->
<!-- Demo Js for skin color etc-->
<!--<script src="--><?php //echo $asset_path_link ?><!--assets/bsb/js/demo.js"></script>-->
<!-- CUSTOM SETTINGS DATETIME Js -->

<!-- ------------------------------------------END HTML FOOTER --------------------------------------------------------------- -->
</html>