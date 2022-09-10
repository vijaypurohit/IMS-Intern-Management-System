<?php
/**
 * Created by PhpStorm.
 * User: Vijay Purohit
 * Date: 06-Jun-19
 * Time: 12:04 PM
 * Project: ims_vj
 */

$asset_path_link='../';
$adm_pages_link='';
$bootstrap_select=1;
$multiSelect=1;

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
    <!-- TEAM -->
    <div class="container-fluid" style="padding-top: 25px">
        <div class="block-header">
            <h2 class="com bo"
                style="text-align: center; font-size: 20px; letter-spacing: 2px; padding-bottom: 5px;">
                TEAMs
            </h2>
        </div>

        <?php  include(INCLUDE_PATH . '/layouts/_messages.php'); ?>
        <!-- CREATE TEAM -->
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
                            CREATE TEAM
                        </h2>
                    </div>
                    <div class="body">
                        <form id="add_team" action="" method="post">
                            <!--FROM OnGoing BATCH-->
                            <div class="row clearfix">
                                <div class="col-sm-12 col-md-12">
                                    <label for="batch_id_from">OnGoing BATCH <?php echo "( ".$tot_ongoing_batch." )" ?> </label>
                                    <select id="batch_id_from" name="batch_id_from" class="form-control show-tick" onchange="fetch_batch_interns(this.value)" required>
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

                            <!--INTERNS TO SELECT-->
                            <div id="select_team_interns"></div>
                            <!--#END# INTERNS TO SELECT-->


                            <!--Team Name-->
                            <div class="row clearfix" id="team_name_row" style="display: none">
                                <div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="team_name"  id="team_name" maxlength="99"  autocomplete="off" required autofocus>
                                            <label for="team_name" class="form-label">NEW TEAM NAME</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- #END# Team Name-->

                            <!--Project Name-->
                            <div class="row clearfix" id="project_name_row" style="display: none">
                                <div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <label for="project_name" class="form-label">NEW PROJECT NAME [optional]</label>
                                            <input type="text" class="form-control" name="project_name" id="project_name" maxlength="99"  autocomplete="off" autofocus>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- #END# Project Name-->

                            <input type="hidden" name="form_token" value="<?php echo $_SESSION['form_token'] ?>" />

                            <div class="m-t-25 m-b--5 align-center">
                                <button class="btn btn-block  bg-deep-purple waves-effect" name="add_teams" type="submit">CREATE</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# CREATE TEAM -->
    </div>
    <!-- #END# TEAM -->
</section>

<!-- ----------------------------------------- END HTML BODY ------------------------------------------------------------ -->

<!-- ----------------------------------------- HTML FOOTER --------------------------------------------------------------- -->
<?php require_once (INCLUDE_PATH .'/layouts/_footer.php'); ?>
<!-- Custom Js -->
<!-- Demo Js for skin color etc-->
<!--<script src="--><?php //echo $asset_path_link ?><!--assets/bsb/js/demo.js"></script>-->

<!-- FOR Loading-->
<script type="text/javascript">
    function fetch_batch_interns(val){
        var batch_id_from = val;

        $.ajax({
            type: 'post',
            url: 'batch_logics.php',
            data: {
                batch_id_from:batch_id_from,
                fetch_batch_interns_for_team:1,
            },
            success: function (response) {
                document.getElementById("select_team_interns").innerHTML=response;
                document.getElementById("project_name_row").style.display = 'block' ;
                document.getElementById("team_name_row").style.display = 'block' ;


                $('#optgroup-c').multiSelect({
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

    $(function () {

        $('#add_team').validate({
            rules: {
                'terms': {
                    required: true
                },

                'team_name': {
                    minlength: 4,
                    remote: {
                        url: "batch_logics.php",
                        type: "post",
                        data: {
                            team_name: function(){ return $("#team_name").val(); },
                            add_teams: "yes",
                            checkunique: "yes"
                        }
                    }
                },
            },
            messages: {
                team_name: {
                    remote: "Team Name already in use!"
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