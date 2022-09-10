<?php
/**
 * Created by PhpStorm.
 * User: Vijay Purohit
 * Date: 14-Jun-19
 * Time: 3:59 PM
 * Project: ims_vj
 */

$asset_path_link = '../';
$int_pages_link = '';
$bootstrap_select=1;
?>
<?php  require_once($asset_path_link.'config.php'); ?>
<?php  require_once (INT_PATH .'/_.php'); ?>
<?php  require_once('task_logics.php'); ?>

<?php
$_SESSION['form_token'] = md5(session_id() . time() . $_SESSION['user']['id']);

$tskId= $_REQUEST['tkid'];
$tsk=getAllTasksOfProjectByTaskId($tskId);

$d = new DateTime($tsk['created_at']);
$formatted_date = $d->format('M, d Y');
$formatted_time = $d->format('h:i A');

$formatted_dateD='';
if($tsk['deadline']!=NULL){
    $dD = new DateTime($tsk['deadline']);
    $formatted_dateD = $dD->format('M, d Y');
}

$d = new DateTime($tsk['created_at']);
$formatted_date = $d->format('M, d Y');
$formatted_time = $d->format('h:i A');

$formatted_dateD='';
if($tsk['deadline']!=NULL){
    $dD = new DateTime($tsk['deadline']);
    $formatted_dateD = $dD->format('M, d Y');
}

$notify_string = $tsk['request'] == tsk_request ? 'NOT SEEN by Admin' : ($tsk['request'] == NULL ? 'NOT SEND' : 'SEEN by Admin');
$notify_string_color = $tsk['request'] == tsk_request ? '#ffc107' : ($tsk['request'] == NULL ? '#ff0707' : '#4caf50');

$c_status_color = 'col-blue';
if ($tsk['status'] == tsk_enable) {
    $c_status_color = 'col-blue';
    $string_s = 'PENDING';
} else if ($tsk['status'] == tsk_disable ) {
    $c_status_color = 'col-orange';
    $string_s = 'DISMISSED';
}else if ($tsk['status'] == tsk_completed ) {
    $c_status_color = 'col-green';
    $string_s = 'COMPLETED';
}

$selected = $tsk['request']== tsk_request ? 'selected' : '';
?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2 class="com bo"
                style="text-align: center; font-size: 20px; letter-spacing: 2px; padding-bottom: 3px;">
                TASK - <?php echo $tsk['title_'] ?>
            </h2>
        </div>
        <div class="row clearfix">
            <div class="col-xs-12 col-sm-12">
                <?php include(INCLUDE_PATH . '/layouts/_messages.php'); ?>
                <div class="row clearfix">
                    <!--task show-->
                    <div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2">
                        <div class="card">
                            <div class="body">
                                <div class="row clearfix">
                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group">
                                        <label>   TASK NAME  :  </label>
                                        <?php echo $tsk['title_']; ?>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group">
                                        <label>   ASSIGNED AT  :  </label>
                                        <?php   echo $formatted_date . " " . $formatted_time ;; ?>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group">
                                        <label>   DEADLINE  :  </label>
                                        <?php echo $formatted_dateD; ?>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group">
                                        <label>   ASSIGNED BY  :  </label>
                                        <?php echo $tsk['created_by_name']; ?>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group">
                                        <label>   PROJECT TO  :  </label>
                                        <?php echo $tsk['project_name']; ?>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group">
                                        <label>   ASSIGNED TO  :  </label>
                                        <?php echo $tsk['intern_name']; ?>
                                    </div>
                                </div>
                                    <div class="col-xs-12 col-md-6">
                                        <div class="form-group">
                                            <label>   NOTIFICATION  :  </label>
                                            <?php echo "<label style='color: $notify_string_color'>".$notify_string." </label>"; ?>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-6">
                                        <div class="form-group">
                                            <label>   STATUS  :  </label>
                                            <?php echo "<label class='$c_status_color'>".$string_s." </label>"; ?>
                                        </div>
                                    </div>
                                <div class="col-xs-12 col-md-12" >
                                    <div class="form-group">
                                        <label style="text-align: center">   DESCRIPTION  :  </label>
                                        <div style="background: lightgoldenrodyellow; ">
                                            <?php echo "<br> ".html_entity_decode($tsk['desc_'])." "; ?>
                                            <hr>
                                        </div>
                                    </div>
                                </div>


                                    <?php
                                    if ($tsk['intern_id'] == $_SESSION['user']['id'] && $tsk['status']!= tsk_completed ) {
//                                        if ($tsk['status'] == tsk_enable) {
//                                            $c_status_color = 'btn-danger';
//                                            $string_s = 'DISMISSED';
//                                            $value_s = -1;
//                                        } else if ($tsk['status'] == tsk_disable ) {
//                                            $c_status_color = 'btn-info';
//                                            $string_s = 'ENABLE';
//                                            $value_s = 1;
//                                        }

                                        ?>
                                    <div class="col-xs-12 col-md-12" >
                                        <form action="task_show.php" method="post">
                                            <input type="hidden" name="form_token" value="<?php echo $_SESSION['form_token'] ?>" />
                                            <input type="hidden" name="task_tid" value="<?php echo $tsk['tkid'] ?>" />
<!--                                            <input type="hidden" name="tkid" value="--><?php //echo $tsk['tkid'] ?><!--" />-->
                                            <input type="hidden" name="title_" value="<?php echo $tsk['title_']; ?>" />

                                            <div class="row clearfix">
                                                <div class="col-sm-12 col-md-12">
                                                    <label for="task_s_option">STATUS </label>
                                                    <select id="task_s_option" name="task_s_option" class="form-control show-tick" required>
                                                        <option value=''>SELECT</option>;
<!--                                                        <option value="--><?php //echo $value_s ?><!--">--><?php //echo $string_s ?><!--</option>;-->
                                                        <option value="<?php echo tsk_inspection ?>" <?php echo $selected ?>>Request For Inspection</option>;
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="m-t-25 m-b--5 align-center">
                                                <button class="btn btn-block  bg-deep-purple waves-effect" name="task_status_submit" id="task_status_submit" type="submit">SUBMIT</button>
                                            </div>
                                        </form>
                                    </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--  #END# Task Show-->
                </div>
        </div>
    </div>
    </div>
</section>

<!-- ----------------------------------------- END HTML BODY ------------------------------------------------------------ -->

<!-- -----------------------------------------HTML FOOTER--------------------------------------------------------------- -->
<?php require_once(INCLUDE_PATH . '/layouts/_footer.php'); ?>

<!-- Custom Js -->
<!-- Demo Js for skin color etc-->
<!--<script src="--><?php //echo $asset_path_link ?><!--assets/bsb/js/demo.js"></script>-->

<?php //echo $uid
if($tsk['notify'] ==1 ){
    updateTaskNotify('-1', $tsk['tkid']);
}
?>
<!-- ------------------------------------------END HTML FOOTER --------------------------------------------------------------- -->
</html>
