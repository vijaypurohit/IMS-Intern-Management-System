<?php
/**
 * Created by PhpStorm.
 * User: Vijay Purohit
 * Date: 03-Jun-19
 * Time: 10:39 AM
 * Project: ims_vj
 */

$asset_path_link='../';
$adm_pages_link='';
$bootstrap_select=1;
$multiSelect=1;
?>
<?php  require_once($asset_path_link.'config.php'); ?>
<?php  require_once (ADM_PATH .'/_.php'); ?>
<?php  require_once('batch_logics.php'); ?>
<?php
// For Double Submit of Form
$_SESSION['form_token'] = md5(session_id() . time() . $_SESSION['user']['id']);
?>

<section class="content">
    <!-- ADD INTERNS NEW -->
    <div class="container-fluid">
        <div class="block-header">
            <h2 class="com bo"
                style="text-align: center; font-size: 20px; letter-spacing: 2px; padding-bottom: 5px;">
               ADD INTERNS
            </h2>
        </div>
        <?php  include(INCLUDE_PATH . '/layouts/_messages.php'); ?>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            NEW INTERNS
                        </h2>
                    </div>
                    <div class="body">
                    <form action="batch_add_interns.php" method="post">
                        <!--BATCH FORM-->
                        <?php
                            global $today_date_normal;
                            $ongoingBatches = getAllOngoingBatches($today_date_normal);
                            $tot_ongoing_batch = count($ongoingBatches);
                        ?>
                        <div class="row clearfix">
                            <div class="col-sm-12 col-md-12">
                            <label for="batch_id">OnGoing BATCHES <?php echo "( ".$tot_ongoing_batch." )" ?> </label>
                            <select id="batch_id" name="batch_id" class="form-control show-tick" required>
                                <option value=''>SELECT BATCH</option>;
                                <?php

                                    foreach ($ongoingBatches as $ob) {
                                        $df = new DateTime($ob['from_d_b']);
                                        $formatted_date_f = $df->format('M, d Y');
                                        $formatted_date_f_normal = $df->format('d-m-Y');

                                        $dt = new DateTime($ob['to_d_b']);
                                        $formatted_date_t = $dt->format('M, d Y');
                                        $formatted_date_t_normal = $dt->format('d-m-Y');

                                        $interval = $df->diff($dt);
                                        $noOfD =  $interval->format('%m months, %R%d days');
                                        echo "<option value='$ob[bid]'>$ob[batch_name] ( $ob[batch_year] ) - $formatted_date_f  - $formatted_date_t  ( $noOfD) </option>";
                                    }
                                ?>
                            </select>
                            </div>
                        </div>
                        <!-- #END# BATCH FORM-->
                        <!--NEW INTERNS-->
                        <?php
                            $created_at_row = array();
                            $new_interns = getAllInternsToAdd() ;
                            $tot_new_int = count($new_interns);
                        ?>
                        <div class="row clearfix" style="padding-bottom: 0px">
                            <div class="col-sm-6 col-md-6">
                                <label for="optgroup"> SELECT NEW INTERNS  <?php echo "( ".$tot_new_int." )" ?> </label>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <li style="text-align: right">
                                    <a href='#' id='select-all'>select all</a>
                                    <a href='#' style="padding-left: 10px" id='deselect-all'>deselect all</a>
                                </li>
                            </div>
                        </div>
                        <select id="optgroup" name="add_interns_listId[]" class="ms" multiple="multiple" required>
                        <?php
                            foreach ($new_interns as $ni) {
//                            for ($i=0; $i< $tot_new_int; $i++) {
//                                $ni = $new_interns[$i];
                                $formatted_created_at = new DateTime($ni['created_at']);
                                $created_at_date = $formatted_created_at->format('M d, Y');

                                if(!in_array($created_at_date,$created_at_row)){
                                    echo "<optgroup label='$created_at_date'>";
                                    $created_at_row[]=$created_at_date;
                                }
                                    echo "<option value='$ni[uid]'>$ni[full_name]</option>";

                                $ni1 = $new_interns[$i+1];
                                $formatted_created_at = new DateTime($ni1['created_at']);
                                $created_at_date = $formatted_created_at->format('M d, Y');
                                if(!in_array($created_at_date,$created_at_row)){
                                    echo "</optgroup>";
                                }

                             }
                        ?>
                        </select>
                        <input type="hidden" name="form_token" value="<?php echo $_SESSION['form_token'] ?>" />
                        <div class="m-t-25 m-b--5 align-center">
                           <button class="btn btn-block  bg-deep-purple waves-effect" name="add_interns" type="submit">ADD TO BATCH</button>
                       </div>
                        <!--END NEW INTERNS-->
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# ADD INTERNS NEW -->
    <!-- CHANGE BATCH -->
    <div class="container-fluid" style="padding-top: 25px">
        <div class="block-header">
            <h2 class="com bo"
                style="text-align: center; font-size: 20px; letter-spacing: 2px; padding-bottom: 5px;">
                CHANGE BATCH
            </h2>
        </div>
        <!-- CHANGE BATCH -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            TRANSFER INTERNS
                        </h2>
                    </div>
                    <div class="body">
                        <form action="batch_add_interns.php" method="post">
                        <!--OLD BATCH FORM-->
                            <div class="row clearfix">
                                <div class="col-sm-12 col-md-12">
                                    <label for="batch_id_from">FROM <?php echo "( ".$tot_ongoing_batch." )" ?> </label>
                                    <select id="batch_id_from" name="batch_id_from" class="form-control show-tick" onchange="fetch_batch_to_view(this.value)" required>
                                        <option value=''>SELECT OLD BATCH</option>;
                                        <?php
                                        foreach ($ongoingBatches as $ob) {
                                            $df = new DateTime($ob['from_d_b']);
                                            $formatted_date_f = $df->format('M, d Y');
                                            $formatted_date_f_normal = $df->format('d-m-Y');

                                            $dt = new DateTime($ob['to_d_b']);
                                            $formatted_date_t = $dt->format('M, d Y');
                                            $formatted_date_t_normal = $dt->format('d-m-Y');

                                            $interval = $df->diff($dt);
                                            $noOfD =  $interval->format('%m months, %R%d days');
                                            echo "<option value='$ob[bid]'>$ob[batch_name] ( $ob[batch_year] ) - $formatted_date_f  - $formatted_date_t  ( $noOfD) </option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        <!-- #END# OLD BATCH FORM-->

                        <!--NEW BATCH FORM-->
                            <div class="row clearfix">
                                <div class="col-sm-12 col-md-12"  >
                                    <div id="select_batch_to"></div>
<!--                                    <label for="batch_id_to">TO --><?php //echo "( ".$tot_ongoing_batch." )" ?><!-- </label>-->
<!--                                    <select id="batch_id_to" name="batch_id_to" class="form-control show-tick" required>-->
<!--                                        <option value=''>SELECT BATCH</option>;-->
<!--                                        --><?php
//                                        foreach ($ongoingBatches as $ob) {
//                                            $df = new DateTime($ob['from_d_b']);
//                                            $formatted_date_f = $df->format('M, d Y');
//                                            $formatted_date_f_normal = $df->format('d-m-Y');
//
//                                            $dt = new DateTime($ob['to_d_b']);
//                                            $formatted_date_t = $dt->format('M, d Y');
//                                            $formatted_date_t_normal = $dt->format('d-m-Y');
//
//                                            $interval = $df->diff($dt);
//                                            $noOfD =  $interval->format('%m months, %R%d days');
//                                            echo "<option value='$ob[bid]'>$ob[batch_name] ( $ob[batch_year] ) - $formatted_date_f  - $formatted_date_t  ( $noOfD) </option>";
//                                        }
//                                        ?>
<!--                                    </select>-->
                                </div>

                            <!-- #END# NEW BATCH FORM-->

                            <div  class="row clearfix" style="padding-bottom: 0px">
    <!--                                <div class="col-sm-6 col-md-6">-->
    <!--                                    <label for="optgroup"> SELECT OLD INTERNS   </label>-->
    <!--                                </div>-->
    <!--                                <div class="col-sm-6 col-md-6">-->
    <!--                                    <li style="text-align: right">-->
    <!--                                        <a href='#' id='select-all-c'>select all</a>-->
    <!--                                        <a href='#' style="padding-left: 10px" id='deselect-all-c'>deselect all</a>-->
    <!--                                    </li>-->
    <!--                                </div>-->
    <!--                                <div class="col-sm-12 col-md-12">-->
    <!--                                    <select id="optgroup-c" name="change_interns_listId[]" class="ms" multiple="multiple" required>-->
    <!--                                    --><?php
    //                                    foreach ($old_interns as $oi) {
    ////                            for ($i=0; $i< $tot_old_int; $i++) {
    ////                                $oi = $old_interns[$i];
    //                                        $formatted_created_at = new DateTime($oi['created_at']);
    //                                        $created_at_date = $formatted_created_at->format('M d, Y');
    //
    //                                        if(!in_array($created_at_date,$created_at_row)){
    //                                            echo "<optgroup label='$created_at_date'>";
    //                                            $created_at_row[]=$created_at_date;
    //                                        }
    //                                        echo "<option value='$oi[uid]'>$oi[full_name]</option>";
    //
    //                                        $oi1 = $old_interns[$i+1];
    //                                        $formatted_created_at = new DateTime($oi1['created_at']);
    //                                        $created_at_date = $formatted_created_at->format('M d, Y');
    //                                        if(!in_array($created_at_date,$created_at_row)){
    //                                            echo "</optgroup>";
    //                                        }
    //
    //                                    }
    //                                    ?>
    <!--                                </select>-->
                                </div>
                                    <div id="select_change_interns"></div>
                            </div>

                            <input type="hidden" name="form_token" value="<?php echo $_SESSION['form_token'] ?>" />

                            <div class="m-t-25 m-b--5 align-center">
                                <button class="btn btn-block  bg-deep-purple waves-effect" name="change_interns" type="submit">CHANGE</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# CHANGE BATCH-->
    </div>
    <!-- #END# CHANGE BATCH -->
</section>

<!-- ----------------------------------------- END HTML BODY ------------------------------------------------------------ -->
<!-- ----------------------------------------- HTML FOOTER --------------------------------------------------------------- -->
<?php require_once (INCLUDE_PATH .'/layouts/_footer.php'); ?>
<!-- Custom Js -->
<!-- Demo Js for skin color etc-->
<!--<script src="--><?php //echo $asset_path_link ?><!--assets/bsb/js/demo.js"></script>-->
<!-- FOR MULTISELECT CONFIGURATION-->
<script type="text/javascript">
    //Multi-select
    $('#optgroup').multiSelect({
            selectableOptgroup: true
        },
        {
            keepOrder: true
        }
    );
    $('#select-all').click(function(){
        $('#optgroup').multiSelect('select_all');
        return false;
    });
    $('#deselect-all').click(function(){
        $('#optgroup').multiSelect('deselect_all');
        return false;
    });
</script>

<!-- FOR Loading-->
<script type="text/javascript">
    function fetch_batch_interns(val){
        let batch_id_from = val;

        $.ajax({
            type: 'post',
            url: 'batch_logics.php',
            data: {
                batch_id_from:batch_id_from,
                fetch_batch_interns:1,
            },
            success: function (response) {
                document.getElementById("select_change_interns").innerHTML=response;
                $('#optgroup-c').multiSelect(
                    {
                        selectableOptgroup: true
                    },
                    {
                        keepOrder: true
                    }
                );
                $('#select-all-c').click(function(){
                    $('#optgroup-c').multiSelect('select_all');
                    return false;
                });
                $('#deselect-all-c').click(function(){
                    $('#optgroup-c').multiSelect('deselect_all');
                    return false;
                });
            }
        });
    }

    function fetch_batch_to_view(val_from){
        let batch_id_from = val_from;

        $.ajax({
            type: 'post',
            url: 'batch_logics.php',
            data: {
                batch_id_from:batch_id_from,
                fetch_batch_to:1,
            },
            success: function (response) {
                document.getElementById("select_batch_to").innerHTML=response;
                // document.getElementById('batch_id_to').classList.add('form-control'); //add
                fetch_batch_interns(val_from);
            }
        });
    }
</script>


<!-- ------------------------------------------END HTML FOOTER --------------------------------------------------------------- -->
</html>