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

    <!-- Project -->
    <div class="container-fluid" style="padding-top: 25px">
        <div class="block-header">
            <h2 class="com bo"
                style="text-align: center; font-size: 20px; letter-spacing: 2px; padding-bottom: 5px;">
                PROJECT
            </h2>
        </div>
        <?php  include(INCLUDE_PATH . '/layouts/_messages.php'); ?>
        <!-- CREATE Project -->
        <?php
            global $today_date_normal;
            $ongoingBatchesTeams = getAllOngoingBatchTeams($today_date_normal);
            $tot_ongoing_batch_teams = count($ongoingBatchesTeams);
        ?>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            CREATE NEW PROJECT
                        </h2>
                    </div>
                    <div class="body">
                        <form id="project_form" action="" method="post">

                            <!--Project Name-->
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <label for="project_name_c" class="form-label">NEW PROJECT NAME</label>
                                        <div class="form-line">

                                            <input type="text" class="form-control" name="project_name_c" id="project_name_c" maxlength="99"  autocomplete="off" autofocus required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- #END# Project Name-->

                            <!--FROM OnGoing BATCH-->
                            <div class="row clearfix">
                                <div class="col-sm-12 col-md-12">
                                    <label for="team_id">CURRENT TEAMS<?php echo "( ".$tot_ongoing_batch_teams." )" ?> </label>
                                    <select  id="team_id" name="team_id" class="form-control show-tick" required>
                                        <option value=''>SELECT TEAM</option>;
                                        <?php
                                        foreach ($ongoingBatchesTeams as $obt) {
                                            $dt = new DateTime($obt['team_timestamp']);
                                            $formatted_date_t = $dt->format('M, d Y');
                                            echo "<option value='$obt[tid]'>$obt[team_name] | (#M $obt[num_members] ) (#P $obt[current_proj]) (B $obt[batch_name])  - @ $formatted_date_t </option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <!-- #END# FROM OnGoing BATCH-->

                            <input type="hidden" name="form_token" value="<?php echo $_SESSION['form_token'] ?>" />

                            <div class="m-t-25 m-b--5 align-center">
                                <button class="btn btn-block  bg-deep-purple waves-effect" name="add_project" type="submit">CREATE</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Project -->
    </div>
    <!-- #END# Project -->
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
        $('#project_form').validate({
            rules: {
                'terms': {
                    required: true
                },
                'project_name_c': {
                    minlength: 4,
                    remote: {
                        url: "batch_logics.php",
                        type: "post",
                        data: {
                            project_name_c: function(){ return $("#project_name_c").val(); },
                            add_project: "yes",
                            checkunique: "yes"
                        }
                    }
                },
            },
            messages: {
                project_name_c: {
                    remote: "Project Name already in use!"
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