<?php
/**
 * Created by PhpStorm.
 * User: Vijay Purohit
 * Date: 09-Jun-19
 * Time: 7:57 PM
 * Project: ims_vj
 */

$asset_path_link='../';
$int_pages_link='';
$bootstrap_select=1;
$dateTimePicker=1;
?>
<?php  require_once($asset_path_link.'config.php'); ?>
<?php  require_once (INT_PATH .'/_.php'); ?>
<?php // require_once('batch_logics.php'); ?>
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
                ATTENDANCE REPORT
            </h2>
        </div>

        <?php  include(INCLUDE_PATH . '/layouts/_messages.php'); ?>
        <!--  Consolidated Report -->
        <?php
        global $today_date_normal;
        $ongoingBatches = getAllOngoingBatchesOfUser($today_date_normal, $user['uid']);
        $tot_ongoing_batch = count($ongoingBatches);
        ?>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            SHOW
                        </h2>
                    </div>
                    <div class="body">

                        <!--FROM OnGoing BATCH-->
                        <div class="row clearfix">
                            <div class="col-sm-12 col-md-12">
                                <label for="batch_id_from">OnGoing BATCH <?php echo "( ".$tot_ongoing_batch." )" ?> </label>
                                <select id="batch_id_from" name="batch_id_from" class="form-control show-tick" onchange=" atnBatch(this.value); " required>
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

                        <input type="hidden" name="intern_id" id="intern_id" value="<?php echo $user['uid'] ?>">

                        <!--DATE-->
                        <div class="row clearfix">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <!--                                <div class="">-->
                                <h2 class="card-inside-title">RANGE</h2>
                                <div class="input-daterange input-group" id="bs_datepicker_range_container">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="from_date" id="from_date" placeholder="Date start..." onchange="document.getElementById('to_date').disabled = false" required>
                                    </div>
                                    <span class="input-group-addon">to</span>
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="to_date" id="to_date" onchange=" document.getElementById('report_type').disabled = false;" placeholder="Date end..." required>
                                    </div>
                                </div>
                                <!--                                </div>-->
                            </div>
                        </div>
                        <!--END DATE-->

                        <!--Report Type-->
                        <div class="row clearfix">
                            <div class="col-sm-12 col-md-12">
                                <label for="report_type">REPORT TYPE</label>
                                <select id="report_type" name="report_type" class="form-control show-tick" onchange="document.getElementById('show_atn_report').disabled = false;" required>
                                    <option value=''>Select Report Type</option>;
                                    <option value='DETAILED'>DETAILED</option>;
                                </select>
                            </div>
                        </div>
                        <!-- #END# Report Type-->

                        <div class="row clearfix">
                            <div class="col-xs-12 col-sm-4 col-sm-offset-8 col-md-3 col-md-offset-9" style="margin-bottom: 0px;">
                                <button class="btn btn-block btn-lg bg-deep-purple waves-effect" name="show_atn_report" onclick="fetch_report()" id="show_atn_report" type="submit">SHOW</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END#  Consolidated Report -->
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
    $(function () {
        //Textarea auto growth
        autosize($('textarea.auto-growth'));
    });
    window.onload = function () {
        document.getElementById("from_date").disabled = true;
        document.getElementById("to_date").disabled = true;
        document.getElementById("report_type").disabled = true;
        document.getElementById("show_atn_report").disabled = true;
    };
    window.onsubmit = function () {
        document.getElementById("batch_id_from").disabled = false;
        document.getElementById("from_date").disabled = false;
        document.getElementById("to_date").disabled = false;
        document.getElementById("report_type").disabled = false;
        document.getElementById("show_atn_report").disabled = false;
    };
    function atnBatch(val) {
        let batch_id_fromSelect = document.getElementById("batch_id_from");
        let selectedText = batch_id_fromSelect.options[batch_id_fromSelect.selectedIndex].text;
        let batch_duration = selectedText.slice(selectedText.indexOf("-")+1, selectedText.lastIndexOf("("));
        let batch_duration_from = batch_duration.slice(0,batch_duration.indexOf("-"));
        let batch_duration_to = batch_duration.slice(batch_duration.indexOf("-")+1);
        let batch_duration_from_formatted = moment(batch_duration_from).format('DD-MM-YYYY');
        let batch_duration_to_formatted = moment(batch_duration_to).format('DD-MM-YYYY');

        document.getElementById("batch_id_from").disabled = true;
        document.getElementById("from_date").disabled = false;

        //Bootstrap datepicker plugin
        $('#bs_datepicker_range_container').datepicker({
            autoclose: true,
            format: "dd-mm-yyyy",
            startDate: batch_duration_from_formatted,
            endDate: batch_duration_to_formatted,
            daysOfWeekDisabled: "0,6",
            daysOfWeekHighlighted: "0,6",
            calendarWeeks: true,
            todayHighlight: true,
            todayBtn: true,
            clearBtn: true,
            // datesDisabled: ['10-06-2019', '06-21-2019'],
            container: '#bs_datepicker_range_container'
        });


    }

    function fetch_report() {
        // fetch_report(batch_name,batch_duration,batch_duration_only_summary, val,batch_duration_from_formattedNormal,batch_duration_to_formattedNormal );
        let val1 =  document.getElementById("batch_id_from").value;
        let val3 =  document.getElementById("report_type").value;
        let from_date =  document.getElementById("from_date").value;
        let to_date =  document.getElementById("to_date").value;
        let intern_id =  document.getElementById("intern_id").value;

        let batch_id_fromSelect = document.getElementById("batch_id_from");
        let selectedText = batch_id_fromSelect.options[batch_id_fromSelect.selectedIndex].text;
        let batch_name = selectedText.slice(0,selectedText.indexOf("-"));
        let batch_duration = selectedText.slice(selectedText.indexOf("-")+1, selectedText.lastIndexOf("("));
        let from_date_formattedNormal = moment(from_date,'DD-MM-YYYY').format('YYYY-MM-DD');
        let to_date_formattedNormal = moment(to_date,'DD-MM-YYYY').format('YYYY-MM-DD');

        var gourle = 'batch_attendance_report_show.php?batch_id_from=';
        var gourlf = val1;
        var gourlg = gourle.concat(gourlf);

        var gourlh = '&from_date=';
        var gourli = gourlg.concat(gourlh);
        var gourlj = from_date_formattedNormal;
        var gourlk = gourli.concat(gourlj);

        var gourll = '&to_date=';
        var gourlm = gourlk.concat(gourll);
        var gourln = to_date_formattedNormal;
        var gourlo = gourlm.concat(gourln);
        var gourlp = '&showAttendanceReport=yes';
        var gourlq = gourlo.concat(gourlp);
        var gourlr = '&batch_name=';
        var gourls = gourlq.concat(gourlr);
        var gourlt = batch_name;
        var gourlu = gourls.concat(gourlt);
        var gourlv = '&batch_duration=';
        var gourlw = gourlu.concat(gourlv);
        var gourlx = batch_duration;
        var gourly = gourlw.concat(gourlx);
        var gourlz = '&report_type=';
        var gourla = gourly.concat(gourlz);
        var gourlb = val3;
        var gourlc = gourla.concat(gourlb);
        var gourld = '&intern_id=';
        var gourlae = gourlc.concat(gourld);
        var gourlaf = intern_id;
        var gourlag = gourlae.concat(gourlaf);
        window.open(gourlag, '_blank');
    }
</script>


<!-- ------------------------------------------END HTML FOOTER --------------------------------------------------------------- -->
</html>
