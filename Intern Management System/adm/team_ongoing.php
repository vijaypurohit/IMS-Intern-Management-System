<?php
/**
 * Created by PhpStorm.
 * User: Vijay Purohit
 * Date: 27-Jun-19
 * Time: 11:01 AM
 * Project: ims_vj
 */


$asset_path_link='../';
$adm_pages_link='';
?>

<?php  require_once($asset_path_link.'config.php'); ?>
<?php  require_once (ADM_PATH .'/_.php'); ?>
<?php // require_once('batch_logics.php'); ?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2 class="com bo"
                style="text-align: center; font-size: 20px; letter-spacing: 2px; padding-bottom: 5px;">
                ONGOING TEAMS
            </h2>
        </div>
<!--        --><?php // include(INCLUDE_PATH . '/layouts/_messages.php'); ?>
        <!-- FIRST ROW -->
        <div class="row clearfix">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                <div class="card " >

                    <div class="body" >
                        <div class="table-responsive" style="position: center; overflow-y: scroll; ">
                            <table  class="table table-condensed table-bordered table-striped table-hover" >
                                <thead>
                                <tr style="font-weight: bold; background: #607d8b; color: white; ">
                                    <th>TEAM NAME</th>
                                    <th data-toggle="tooltip" data-placement="top" title="number of members" >#M</th>
                                    <th data-toggle="tooltip" data-placement="top" title="number of projects" >#P</th>
                                    <th>CREATED AT</th>
                                    <th>BATCH</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr style="font-weight: bold; background: #607d8b; color: white; table-layout: fixed">
                                    <th>TEAM NAME</th>
                                    <th data-toggle="tooltip" data-placement="bottom" title="number of members">#M</th>
                                    <th data-toggle="tooltip" data-placement="bottom" title="number of projects">#P</th>
                                    <th>CREATED AT</th>
                                    <th>BATCH</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                <?php
                                global $today_date_normal;
                                $ongoingTeams = getAllOnGoingTeams($today_date_normal);
                                foreach ($ongoingTeams as $tm) {

                                    $d = new DateTime($tm['team_timestamp']);
                                    $formatted_date = $d->format('M, d Y');
                                    $formatted_time = $d->format('h:i A');

                                    $df = new DateTime($tm['from_d_b']);
                                    $formatted_date_f = $df->format('M, d Y');
                                    $formatted_date_f_normal = $df->format('d-m-Y');
                                    $dt = new DateTime($tm['to_d_b']);
                                    $formatted_date_t = $dt->format('M, d Y');
                                    $formatted_date_t_normal = $dt->format('d-m-Y');
                                    $interval = $df->diff($dt);
                                    $noOfD =  $interval->format('%m months, %R%d days');

                                    echo "<tr>";

                                    echo "<td style='color: red' >";
                                    echo "<a href='team_ind_home.php?tid=$tm[tid]' target='_blank' style='color: inherit'>";
                                    echo $tm['team_name']." (".$tm['batch_year'].") ";
                                    echo "</a>";
                                    echo "</td>";

                                    echo "<td>";
                                    echo $tm['num_members'];
                                    echo "</td>";
                                    echo "<td>";
                                    echo $tm['num_projects'];
                                    echo "</td>";
                                    echo "<td>";
                                    echo $formatted_date . " <br> " . $formatted_time ;;
                                    echo "</td>";
//                                    echo "</tr>";

//                                    echo "<tr>";
                                    echo "<td colspan='4' style='text-align: center; font-weight: bold; color: blueviolet;'>";
                                    echo $tm['batch_name']." (".$tm['batch_year'].") ".$formatted_date_f." - ".$formatted_date_t." (".$noOfD.")";
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
<script type="text/javascript">
    $(function () {

    });
</script>
<!-- ------------------------------------------END HTML FOOTER --------------------------------------------------------------- -->
</html>