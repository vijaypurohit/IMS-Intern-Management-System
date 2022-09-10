<?php
/**
 * Created by PhpStorm.
 * User: Vijay Purohit
 * Date: 13-Jun-19
 * Time: 12:08 PM
 * Project: ims_vj
 */

$asset_path_link='../';     // to link the asset folder with current level.
$adm_pages_link='';         // to link the pages in directory to the admin base level pages.
$bootstrap_select=1;
$multiSelect=1;
$dateTimePicker=1;
?>
<?php  require_once($asset_path_link.'config.php'); ?>
<?php  require_once (ADM_PATH .'/_.php'); ?>
<?php  require_once('task_logics.php'); ?>
<?php  // For Double Submit of Form
$_SESSION['form_token'] = md5(session_id() . time() . $_SESSION['user']['id']); ?>


<section class="content">
    <?php  include(INCLUDE_PATH . '/layouts/_messages.php'); ?>
    <div class="container-fluid">
        <h2 class="com bo"
            style="text-align: center; font-size: 20px; letter-spacing: 2px; padding-bottom: 5px;">
            TASK
        </h2>
        <!-- TASK -->
        <?php
            global $today_date_normal;
            $ongoingBatches = getAllOngoingBatches($today_date_normal);
            $tot_ongoing_batch = count($ongoingBatches);
        ?>
        <div class="row clearfix">
            <!-- CREATE TASK -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>CREATE</h2>
                    </div>
                    <div class="body">
                        <form action="tasks_create.php" method="post">
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

                            <!--TASK TITLE -->
                            <div class="row clearfix" id="task_title_row" style="display: none" >
                                <div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <label for="task_name" class="form-label">NEW TASK NAME</label>
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="task_name"  id="task_name" maxlength="99"  autocomplete="off" required autofocus>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- #END# TASK TITLE-->

                            <!--TASK DESCRIPTION-->
                            <div class="row clearfix" id="task_desc_row" style="display: none" >
                                <div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <label for="ckeditor" class="form-label">TASK DESCRIPTION</label>
                                            <textarea id="ckeditor" name="task_desc" required><h2>Task</h2>
                                                <p>THIS is paragraph text</p>
                                                <h3>steps</h3>
                                                <ul>
                                                    <li>STEP 1</li>
                                                    <li>STEP 2</li>
                                                    <li>STEP 3</li>
                                                </ul>
                                            </textarea>
<!--                                        <label class="form-label" style="text-align: right; font-weight: normal; padding-top: 10px;" id="charNum"> </label>-->
                                    </div>
                                </div>
                            </div>
                            <!-- #END# TASK DESCRIPTION-->

                            <!--DEADLINE-->
                            <div class="row clearfix" id="deadline_task_row" style="display: none" data-toggle="tooltip" data-placement="top" title="deadline of task optional">
                                <div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="col-sm-6">
                                            <div class="form-group">

                                                <label for="deadline-task">DEADLINE</label>
                                                <div class="form-line"><input type="text" name="deadline_task" class="datepicker form-control" id="deadline-task" placeholder="deadline [optional]..." >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- #END# DEADLINE-->

                            <?php
                            $projects =    getAllProjects();
                            $tot_projects =    count($projects);
                            ?>

                            <!--FROM OnGoing BATCH-->
                            <div class="row clearfix" id="project_row" style="display: none" >
                                <div class="col-sm-12 col-md-12" data-toggle="tooltip" data-placement="top" title="project of task optional">
                                    <label for="project_row_id">OnGoing Project <?php echo "( ".$tot_projects." )" ?> </label>
                                    <select id="project_row_id" name="project_row_id" class="form-control show-tick">
                                        <option value=''>SELECT PROJECT</option>;
                                        <?php
                                        foreach ($projects as $p) {
                                            $d = new DateTime($p['created_at']);
                                            $formatted_date = $d->format('M, d Y');

                                            echo "<option value='$p[id]'>$p[project_name] (@ $formatted_date )</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <!-- #END# FROM OnGoing BATCH-->

                            <input type="hidden" name="form_token" value="<?php echo $_SESSION['form_token'] ?>" />

                            <div class="m-t-25 m-b--5 align-center">
                                <button class="btn btn-block  bg-deep-purple waves-effect" name="add_task" id="add_task" type="submit">CREATE</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <!-- #END# CREATE TASK -->
        </div>
    </div>
</section>

<!-- ----------------------------------------- END HTML BODY ------------------------------------------------------------ -->

<!-- -----------------------------------------HTML FOOTER--------------------------------------------------------------- -->
<?php require_once (INCLUDE_PATH .'/layouts/_footer.php'); ?>

<!-- Custom Js -->
<!-- Ckeditor -->
<script src="<?php echo $asset_path_link ?>/assets/bsb/plugins/ckeditor/ckeditor.js"></script>
<!-- Demo Js for skin color etc-->
<!--        <script src="--><?php //echo $asset_path_link ?><!--assets/bsb/js/demo.js"></script>-->
<script type="text/javascript">
    function fetch_batch_interns(val){
        let batch_id_from = val;

        $.ajax({
            type: 'post',
            url: 'batch_logics.php',
            data: {
                batch_id_from:batch_id_from,
                fetch_batch_interns_for_team:1,
            },
            success: function (response) {
                document.getElementById("select_team_interns").innerHTML=response;
                document.getElementById("task_title_row").style.display = 'block' ;
                document.getElementById("task_desc_row").style.display = 'block' ;
                document.getElementById("deadline_task_row").style.display = 'block' ;
                document.getElementById("project_row").style.display = 'block' ;

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
        //CKEditor
        CKEDITOR.replace('ckeditor');
        CKEDITOR.config.height = 250;
        CKEDITOR.config.extraPlugins = 'codesnippet';
        CKEDITOR.config.filebrowserUploadUrl = '../uploads/editors/upload.php';

        let today_date =  moment().format('dddd DD MMMM YYYY');
        $('#deadline-task').bootstrapMaterialDatePicker({
            format: 'dddd DD MMMM YYYY',
            clearButton: true,
            weekStart: 0,
            minDate: today_date,
            color: '#fffab0',
            time: false
        })

    });
</script>

<!-- ------------------------------------------END HTML FOOTER --------------------------------------------------------------- -->
</html>
