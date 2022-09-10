<?php
/**
 * Created by PhpStorm.
 * User: Vijay Purohit
 * Date: 31-May-19
 * Time: 1:54 PM
 * Project: ims_vj
 */

$asset_path_link='../';
$adm_pages_link='';
$bootstrap_select=1;
$dateTimePicker=1;
$jqueryValidate=1;
?>

<?php  require_once($asset_path_link.'config.php'); ?>
<?php  require_once (ADM_PATH .'/_.php'); ?>
<?php  require_once('batch_logics.php'); ?>
<?php
// For Double Submit of Form
$_SESSION['form_token'] = md5(session_id() . time() . $_SESSION['user']['id']);
?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2 class="com bo"
                style="text-align: center; font-size: 20px; letter-spacing: 2px; padding-bottom: 5px;">
                BATCH CREATE
            </h2>
        </div>
        <?php  include(INCLUDE_PATH . '/layouts/_messages.php'); ?>
        <!-- FIRST ROW -->
        <div class="row clearfix">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" >
                <div class="signup-box">

                    <div class="card " style="position: center">
                        <div class="body">
                            <form id="sign_up" action="" method="POST">
                                <div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" id="batch_name_r" name="batch_name" maxlength="50" class="form-control" required>
                                            <label for="batch_name" class="form-label">Batch Name</label>
                                        </div>
                                    </div>
                                </div><!--batch name-->
                                <?php $years = range( date('Y'), date('Y', strtotime('+1 year'))); ?>
                                <div class="col-sm-12">
                                    <select class="form-control show-tick" name="batch_year" required>
                                        <option>Select Year</option>
                                        <?php foreach($years as $year) : ?>
                                            <option value="<?php echo $year; ?>" <?php echo $year==$today_date_year? 'selected' : '' ?>><?php echo $year; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div><!--year-->
                                <div class="row clearfix">
                                    <div class="col-sm-12">
                                        <div class="col-sm-5">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" name="batch_start_date" class="datepicker form-control" id="date-start" placeholder="start date..." required>
                                                </div>
                                            </div>
                                        </div><!--from-->
                                        <div class="col-sm-1">
                                            <span class="add-on">to</span>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" name="batch_end_date" class="datepicker form-control" id="date-end" placeholder="end date..." required>
                                                </div>
                                            </div>
                                        </div><!--to-->
                                    </div>
                                </div>
                                <input type="hidden" name="form_token" value="<?php echo $_SESSION['form_token'] ?>" />
                                <button class="btn btn-block btn-lg bg-deep-purple waves-effect" name="batch_create" type="submit">CREATE</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" >
                <div class="card " >
                    <div class="header">
                        <h2>
                            OnGoing Batches
                        </h2>
                    </div>
                    <div class="body" >
                        <div class="table-responsive" style="position: center; overflow-y: scroll;">
                            <table  class="table table-condensed table-bordered table-striped table-hover" >
                                <thead>
                                <tr style="font-weight: bold; background: #607d8b; color: white; ">
                                    <th>BATCH NAME</th>
                                    <th>#N</th>
                                    <th>BY</th>
                                    <th>CREATED AT</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr style="font-weight: bold; background: #607d8b; color: white; table-layout: fixed">
                                    <th>BATCH NAME</th>
                                    <th>#N</th>
                                    <th>BY</th>
                                    <th>CREATED AT</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                <?php
                                global $today_date_normal;
                                $ongoingBatches = getAllOngoingBatches($today_date_normal);
                                foreach ($ongoingBatches as $ob) {

                                    $df = new DateTime($ob['from_d_b']);
                                    $formatted_date_f = $df->format('M, d Y');
                                    $formatted_date_f_normal = $df->format('d-m-Y');

                                    $dt = new DateTime($ob['to_d_b']);
                                    $formatted_date_t = $dt->format('M, d Y');
                                    $formatted_date_t_normal = $dt->format('d-m-Y');

//                                    $interval = $df->diff($dt);
//                                        $noOfD = $interval->format('%a');
//                                    $dayStr = $noOfD>1? 'days':'day';
//                                     $noOfD=(int)$noOfD+1;

                                    $interval = $df->diff($dt);
                                    $noOfD =  $interval->format('%m months, %R%d days');

                                    $d = new DateTime($ob['created_at']);
                                    $formatted_date = $d->format('M, d Y');
                                    $formatted_time = $d->format('h:i A');
                                    $formatted_m_n = $d->format('m');


//                                    if( $today_date_normal >= $formatted_date_f_normal && $today_date_normal<= $formatted_date_t_normal):

                                        echo "<tr>";
                                            echo "<td style='color: red'>";
                                                echo $ob['batch_name']." (".$ob['batch_year'].") ";
                                            echo "</td>";
                                            echo "<td>";
                                                echo $ob['number_of_interns'];
                                            echo "</td>";
                                            echo "<td>";
                                                echo $ob['created_by_name'];
                                            echo "</td>";
                                            echo "<td>";
                                                echo $formatted_date . " <br> " . $formatted_time ;;
                                            echo "</td>";
                                        echo "</tr>";

                                        echo "<tr>";
                                            echo "<td colspan='4' style='text-align: center; font-weight: bold; color: blueviolet;'>";
                                                echo $formatted_date_f." - ".$formatted_date_t." (".$noOfD.")";
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
        //Textarea auto growth
        autosize($('textarea.auto-growth'));

        let lastWeekLimit =  moment().subtract(7, 'days').format('dddd DD MMMM YYYY');
        $('#date-end').bootstrapMaterialDatePicker({
            format: 'dddd DD MMMM YYYY',
            clearButton: true,
            weekStart: 0,
            minDate: lastWeekLimit,
            color: '#fff',
            time: false
        }).on('change', function (e, date) {
            $('#date-start').bootstrapMaterialDatePicker('setMinDate', date);
        });
        $('#date-start').bootstrapMaterialDatePicker({
            format: 'dddd DD MMMM YYYY',
            clearButton: true,
            weekStart: 0,
            minDate: lastWeekLimit,
            time: false
        }).on('change', function (e, date) {
            $('#date-end').bootstrapMaterialDatePicker('setMinDate', date);
        });
    });
    $(function () {

        jQuery.validator.addMethod("alphanumeric", function(value, element) {
            return this.optional(element) || /^[\w]+$/i.test(value);
        }, "Letters, numbers, and underscores only please");


        $('#sign_up').validate({
            rules: {
                'terms': {
                    required: true
                },

                'batch_name': {
                    minlength: 4,
                    alphanumeric: true,
                    remote: {
                        url: "batch_logics.php",
                        type: "post",
                        data: {
                            batch_name: function(){ return $("#batch_name_r").val(); },
                            batch_create: "yes",
                            checkunique: "yes"
                        }
                    }
                },
            },
            messages: {
                batch_name: {
                    remote: "Batch Name already in use!"
                },
            },
            highlight: function (input) {
                // console.log(input);
                $(input).parents('.form-line').addClass('error');
            },
            unhighlight: function (input) {
                $(input).parents('.form-line').removeClass('error');
            },
            errorPlacement: function (error, element) {
                $(element).parents('.input-group').append(error);
                $(element).parents('.form-group').append(error);
            }
        });
    });
</script>
<!-- ------------------------------------------END HTML FOOTER --------------------------------------------------------------- -->
</html>