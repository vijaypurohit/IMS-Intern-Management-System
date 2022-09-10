<?php
/**
 * Created by PhpStorm.
 * User: Vijay Purohit
 * Date: 01-Jul-19
 * Time: 12:15 AM
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
               ONGOING BATCH INTERNS
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
                                    <th>INTERN NAME</th>
                                    <th>EMAIL</th>
                                    <th>REGISTERED AT</th>
                                    <th>BATCH</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr style="font-weight: bold; background: #607d8b; color: white; table-layout: fixed">
                                    <th>INTERN NAME</th>
                                    <th>EMAIL</th>
                                    <th>REGISTERED AT</th>
                                    <th>BATCH</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                <?php
                                $ongoingBatchInterns = getAllOngoingBatchesInternsList($today_date_normal);
                                foreach ($ongoingBatchInterns as $obi) {

                                    $d = new DateTime($obi['created_at']);
                                    $formatted_date = $d->format('M, d Y');
                                    $formatted_time = $d->format('h:i A');

                                    $df = new DateTime($obi['from_d_b']);
                                        $formatted_date_f = $df->format('M, d Y');
                                        $formatted_date_f_normal = $df->format('d-m-Y');
                                    $dt = new DateTime($obi['to_d_b']);
                                        $formatted_date_t = $dt->format('M, d Y');
                                        $formatted_date_t_normal = $dt->format('d-m-Y');
                                    $interval = $df->diff($dt);
                                    $noOfD =  $interval->format('%m months, %R%d days');

                                    echo "<tr>";

                                    echo "<td style='color: red' >";
                                        echo "<a href='users/user_profile_view.php?uid=$obi[uid]' target='_blank' style='color: inherit'>";
                                        echo $obi['full_name'];
                                        echo "</a>";
                                    echo "</td>";

                                    echo "<td>";
                                    echo $obi['email'];
                                    echo "</td>";

                                    echo "<td>";
                                        echo $formatted_date . " <br> " . $formatted_time ;;
                                    echo "</td>";
                                        echo "<td colspan='4' style='text-align: center; font-weight: bold; color: blueviolet;'>";
                                        echo $obi['batch_name']." (".$obi['batch_year'].") ".$formatted_date_f." - ".$formatted_date_t." (".$noOfD.")";
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