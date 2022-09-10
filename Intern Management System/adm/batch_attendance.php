<?php
/**
 * Created by PhpStorm.
 * User: Vijay Purohit
 * Date: 07-Jun-19
 * Time: 11:33 AM
 * Project: ims_vj
 */


$asset_path_link='../';
$adm_pages_link='';
$bootstrap_select=1;
?>
<style type="text/css">
    .bgred{
        background-color:#FF5858 !important;
        color:#FFF !important;
    }
    .bgneo {
        background-color: #434343 !important;
        color: #FFF !important;
    }
    .bgblue {
        background-color: #6fa7dc  !important;
        color: #FFF !important;
    }
    .bgwht{
        background-color:#FFF !important;
        color:#333 !important;
    }
</style>

<?php  require_once($asset_path_link.'config.php'); ?>
<?php  require_once (ADM_PATH .'/_.php'); ?>
<?php  require_once('batch_logics.php'); ?>
<?php
// For Double Submit of Form
$_SESSION['form_token'] = md5(session_id() . time() . $_SESSION['user']['id']);
?>

<section class="content">
    <!-- TEAM -->
    <div class="container-fluid" style="padding-top: 25px">
        <div class="block-header">
            <h2 class="com bo"
                style="text-align: center; font-size: 20px; letter-spacing: 2px; padding-bottom: 5px;">
                ATTENDANCE
            </h2>
        </div>

        <?php  include(INCLUDE_PATH . '/layouts/_messages.php'); ?>
        <!-- MARK ATTENDANCE -->
        <?php
            global $today_date_normal;
            $ongoingBatches = getAllOngoingBatches($today_date_normal);
            $tot_ongoing_batch = count($ongoingBatches);
        ?>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            MARK ATTENDANCE
                        </h2>
                    </div>
                    <div class="body">

                        <!--FROM OnGoing BATCH-->
                        <div class="row clearfix">
                            <div class="col-sm-12 col-md-12">
                                <label for="batch_id_from">OnGoing BATCH <?php echo "( ".$tot_ongoing_batch." )" ?> </label>
                                <select id="batch_id_from" name="batch_id_from" class="form-control show-tick" onchange=" copyBatch(this.value); " required>
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
                        <!-- #END# FROM OnGoing BATCH-->

                        <!--DATE-->
                        <div class="row clearfix">
                        <div class="col-xs-12 col-sm-8 col-md-4" >
                            <div class="form-group form-float">
                                <label for="batch_id_from">DATE</label>
                                <div class="form-line">
                                    <input type="date"  class="form-control" id="atd_date" name="atd_date" min="<?php echo date("Y-m-d", strtotime("-1 week")); ?>" max="<?php echo date('Y-m-d'); ?>" onchange="copyDate()">
                                </div>
                            </div>
                        </div>
                        </div>
                        <!--END DATE-->

                    </div>
                </div>
            </div>
        </div>
        <!-- #END# MARK ATTENDANCE -->

        <form id="form_bAttendance_id" action="batch_attendance.php" method="post">
        <!-- INTERNS LIST -->
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h2 class="com" style=" line-height:35px; text-align: center; color: #3f51b5;">
                            <span id="list_show_batch_name" style="color: gold; font-weight: bold; "></span>
                            <span id="list_show_batch_duration" style="color: darkblue"></span>
                            <span id="list_show_batch_duration_summary"></span>
                            <span id="list_show_date" style="color: crimson" ></span>
                        </h2>
                    </div>
                    <div class="body" style="padding-bottom: 0px !important;">
                        <div class="row clearfix" style="padding-top: 10px; ">

                            <input type="hidden" name="form_token" value="<?php echo $_SESSION['form_token'] ?>" />
                            <input type="hidden" id="select_batch" name="batch_id" required>
                            <input type="hidden" id="select_date" name="date_" required>

                            <!--INTERNS TO SELECT-->
                            <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1" >
                                <div id="select_attendance_interns">

                                </div>

                            </div>
                            <!--#END# INTERNS TO SELECT-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# INTERNS LIST -->
        </form>
    </div> <!-- #END# Container FLUID -->


</section>
<!-- ----------------------------------------- END HTML BODY ------------------------------------------------------------ -->

<!-- ----------------------------------------- HTML FOOTER --------------------------------------------------------------- -->
<?php require_once (INCLUDE_PATH .'/layouts/_footer.php'); ?>
<!-- Custom Js -->
<!-- Demo Js for skin color etc-->
<!--<script src="--><?php //echo $asset_path_link ?><!--assets/bsb/js/demo.js"></script>-->

<!-- ATTENDANCE-->
<script type="text/javascript">
    window.onload = function () {
        document.getElementById("atd_date").disabled = true;
    };
    window.onsubmit = function () {
        document.getElementById("batch_id_from").disabled = false;
        document.getElementById("atd_date").disabled = false;
    };

    function copyBatch(val) {
        let batch_id_fromSelect = document.getElementById("batch_id_from");
        let selectedText = batch_id_fromSelect.options[batch_id_fromSelect.selectedIndex].text;
        let batch_name = selectedText.slice(0,selectedText.indexOf("-"));
        let batch_duration_with_summary = selectedText.slice(selectedText.indexOf("-")+1);
        let batch_duration = selectedText.slice(selectedText.indexOf("-")+1, selectedText.lastIndexOf("("));
        let batch_duration_only_summary = selectedText.slice(selectedText.lastIndexOf("("));

        document.getElementById("select_batch").value = val;
        document.getElementById("list_show_batch_name").innerHTML = batch_name.concat("<br>");
        document.getElementById("list_show_batch_duration").innerHTML = batch_duration.concat(" | ").concat(batch_duration_only_summary).concat("");

        document.getElementById("batch_id_from").disabled = true;
        document.getElementById("atd_date").disabled = false;
        // document.getElementById("list_show_batch_duration_summary").innerHTML = batch_duration_only_summary.concat("");
        // document.getElementById("list_show_batch_duration_summary").innerHTML = batch_name.concat("<br>").concat(batch_duration).concat("<br>").concat(batch_duration_only_summary);
    }

    function copyDate() {
        document.getElementById("select_date").value = document.getElementById("atd_date").value;
        document.getElementById("list_show_date").innerHTML = "<br> @: ".concat(document.getElementById("atd_date").value);

        document.getElementById('atd_date').disabled = true;

        fetch_batch_interns( );
    }

    function cons(x, y) {
        let value;
        if (parseInt(x) === <?php echo absent?>) {
            // document.getElementsByClassName(y)[0].value = "0";
            document.getElementById('sel_'+y).className = "bgred";
            value=-1;
        } else if (parseInt(x) === <?php echo present?>)  {
            // document.getElementsByClassName(y)[0].value = "1";
            document.getElementById('sel_'+y).className = "bgwht";
            value=+1;
        }

        let d = document.getElementById('totalRowsID').value;

        let al = 0;
        let pl = 0;
        let status ;
        let statusV ;
        for (let i = 1; i <= d; i++) {
             status = document.getElementById(i);
             statusV = status.options[status.selectedIndex].value;
            // al = parseInt(al) + parseInt(document.getElementsByClassName('vp')[i].value); //1
            if(parseInt(statusV) === <?php echo present?>){
                al = parseInt(al) + 1; //1
            }else if(parseInt(statusV)  === <?php echo absent?>){
                pl = parseInt(pl) + 1; //1
            }

        }
        document.getElementById("prs").innerHTML = al;
        document.getElementById("abs").innerHTML = pl;

    }

    function fetch_batch_interns(){
        var batch_id_from = document.getElementById("batch_id_from").value;
        var attendance_date = document.getElementById("select_date").value;

        $.ajax({
            type: 'post',
            url: 'batch_logics.php',
            data: {
                batch_id_from:batch_id_from,
                attendance_date:attendance_date,
                fetch_attendance_interns:1,
            },
            success: function (response) {
                document.getElementById("select_attendance_interns").innerHTML=response;

            }
        });
    }
</script>

<!-- ------------------------------------------END HTML FOOTER --------------------------------------------------------------- -->
</html>


