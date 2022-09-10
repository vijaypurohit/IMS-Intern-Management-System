<?php
/**
 * Created by PhpStorm.
 * User: Vijay Purohit
 * Date: 31-May-19
 * Time: 3:45 PM
 * Project: ims_vj
 */

$asset_path_link='../';
require_once($asset_path_link.'config.php');

require_once(INCLUDE_PATH . "/logic/common_functions.php");

$user_s = $_SESSION['user'];
$userId = $user_s['id'];

const pj_pending = 1;
const pj_completed =2;
const pj_dismissed = -1;

if (isset($_SESSION['form_token']) && isset($_POST['form_token']) && ($_POST['form_token'] != $_SESSION['form_token'] ) ) {
    $_SESSION['msg'] = "Form Submitted Already";
    $_SESSION['msg_color'] = 'bg-blue';
    return;
}

if(isset($_REQUEST['batch_create'])){

    $batch_name = $_REQUEST['batch_name'];

    $oldBatch_name = checkBatchName($batch_name);
    // if request is from javascript to check validation of uniqueness and error is found
    if (!empty($oldBatch_name['batch_name']) && $oldBatch_name['batch_name'] === $batch_name) { // if user exists
        $_SESSION['msg'] = "Batch Name already exists";
        $_SESSION['msg_color'] = 'bg-orange';
        echo "false";
        return;
    }
    // if request is from javascript to check validation and no error is found
    if(isset($_REQUEST['checkunique']) && $_REQUEST['checkunique']=="yes" ){
        echo "true";
        return;
    }

    if(empty($_REQUEST['batch_name']) || empty($_REQUEST['batch_year'])  || empty($_REQUEST['batch_start_date']) || empty($_REQUEST['batch_end_date']) ){
        $_SESSION['msg'] = "All the fields are required!";
        $_SESSION['msg_color'] = 'bg-teal';
        return ;
    }

//    $batch_name = $_REQUEST['batch_name'];
    $batch_name = ucwords($batch_name);
    $batch_year = $_REQUEST['batch_year'];
    $batch_start_date = $_REQUEST['batch_start_date'];
    $batch_end_date = $_REQUEST['batch_end_date'];

    try {
        $batch_start_date_string = new DateTime($batch_start_date);
    } catch (Exception $e) {
        error_log($e->getMessage());
        $_SESSION['msg'] = "Hey, Developer here, You can't select dates like that";
        $_SESSION['msg_color'] = 'bg-orange';
        return;
    }
    $batch_start_date_string_time =  $batch_start_date_string->format('Y-m-d');

    try {
        $batch_end_date_string = new DateTime($batch_end_date);
    } catch (Exception $e) {
        error_log($e->getMessage());
        $_SESSION['msg'] = "Hey, Developer here, You can't select dates like that";
        $_SESSION['msg_color'] = 'bg-orange';
        return;
    }
    $batch_end_date_string_time =  $batch_end_date_string->format('Y-m-d');

    if ($batch_start_date_string_time > $batch_end_date_string_time) {
        $_SESSION['msg'] = "Hey, Developer here, You can't select dates like that";
        $_SESSION['msg_color'] = 'bg-orange';
        return ;
    }

    $result = insertBatches($batch_name,$batch_year,$batch_start_date_string_time,$batch_end_date_string_time,$userId);
    if($result){
        $_SESSION['msg'] = "New Batch Created Successfully";
        $_SESSION['msg_color'] =  'alert-success';

    }else{
        $_SESSION['msg'] = 'Error!!';
        $_SESSION['msg_color'] =  'alert-danger';
    }

    unset($_REQUEST['batch_create']);
    return;
}

//TO ADD NEW INTERNS
if(isset($_REQUEST['add_interns'])){

    if(empty($_REQUEST['add_interns_listId']) || empty($_REQUEST['batch_id'])){
        $_SESSION['msg'] = "All the fields are required!";;
        $_SESSION['msg_color'] = 'bg-teal';
        return ;
    }

//    if (isset($_SESSION['form_token']) && isset($_POST['form_token']) && ($_POST['form_token'] != $_SESSION['form_token'] ) ) {
//        $_SESSION['msg'] = "Form Submitted Already";
//        $_SESSION['msg_color'] = 'bg-blue';
//        return;
//    }

    $selected_interns_id = $_REQUEST['add_interns_listId'];
    $batch_id            = $_REQUEST['batch_id'];

    $total_interns_selected = count($selected_interns_id);

    $result = array();
    $tot_interns_added=0;
    $error_in_count=0;

    foreach ($selected_interns_id as $sid){
        $result[$sid] = insertBatchInterns($batch_id,$sid,$userId);
        if ( $result[$sid] == true){
            $tot_interns_added++;
        }else{
            $error_in_count++;
        }
    }

//var_dump($selected_interns_id);
//    var_dump($result);
//var_dump($selected_interns_id_serialised);
//var_dump($selected_interns_id_str);
//var_dump($total_interns_selected);
//    $counts = array_count_values($result);
//    var_dump($counts);
//    $tot_interns_added = count($result);

    if($tot_interns_added == $total_interns_selected){
        $_SESSION['msg'] = $tot_interns_added." New Interns Added Successfully";
        $_SESSION['msg_color'] =  'alert-success';
    }else{
        $error_in_c = $total_interns_selected-$tot_interns_added ;
        $_SESSION['msg'] = 'Error!! '.$error_in_count.' This Much Interns Not Added.';
        $_SESSION['msg_color'] =  'alert-danger';
    }

    unset($_REQUEST['add_interns']);
    return;
}

// TO CHANGE INTERNS
if(isset($_REQUEST['change_interns'])){

    if(empty($_REQUEST['change_interns_listId']) || empty($_REQUEST['batch_id_from']) || empty($_REQUEST['batch_id_to']) ){
        $_SESSION['msg'] = "All the fields are required!";;
        $_SESSION['msg_color'] = 'bg-teal';
        return ;
    }

//    if (isset($_SESSION['form_token']) && isset($_POST['form_token']) && ($_POST['form_token'] != $_SESSION['form_token'] ) ) {
//        $_SESSION['msg'] = "Form Submitted Already";
//        $_SESSION['msg_color'] = 'bg-blue';
//        return;
//    }

    $selected_toChange_interns_id = $_REQUEST['change_interns_listId'];
    $batch_id_from = $_REQUEST['batch_id_from'];
    $batch_id_to = $_REQUEST['batch_id_to'];

    $total_interns_selected = count($selected_toChange_interns_id);

    $result = array();
    $tot_interns_added=0;
    $error_in_count=0;

    foreach ($selected_toChange_interns_id as $sid){
        $result[$sid] = insertBatchInterns($batch_id_to,$sid,$userId);
        if ( $result[$sid] == true){
            $r=updateChangeBatch($batch_id_from,$sid);
            $tot_interns_added++;
        }else{
            $error_in_count++;
        }
    }
//    var_dump($batch_id_from);
//    var_dump($batch_id_to);
//    var_dump($selected_toChange_interns_id);
//    var_dump($total_interns_selected);
    $tot_interns_added = count($result);

    if($tot_interns_added == $total_interns_selected){
        $_SESSION['msg'] = $tot_interns_added." Interns Transferred Successfully";
        $_SESSION['msg_color'] =  'alert bg-green';
    }else{
        $error_in_c = $total_interns_selected-$tot_interns_added ;
        $_SESSION['msg'] = 'Error!! '.$error_in_count.' This Much Interns Not Transferred.';
        $_SESSION['msg_color'] =  'alert-danger';
    }
    unset($_REQUEST['change_interns']);
    return;
}

// TO FETCH INTERNS
if(isset($_REQUEST['fetch_batch_interns']) && $_REQUEST['fetch_batch_interns']==1){
    $batch_id_from = $_REQUEST['batch_id_from'];

    $created_at_row = array();
    $old_interns = getAllInternsToChangeBatch($batch_id_from) ;
    $tot_old_int = count($old_interns);

    echo "<div class='col-sm-6 col-md-6'>
                <label for='optgroup'> SELECT BATCH INTERNS   ( $tot_old_int  )</label>
            </div>
            <div class='col-sm-6 col-md-6'>
                <li style='text-align: right'>
                    <a href='#' id='select-all-c'>select all</a>
                    <a href='#' style='padding-left: 10px' id='deselect-all-c'>deselect all</a>
                </li>
            </div>
        ";
    echo "<div class='col-sm-12 col-md-12'>";
    echo "<select id='optgroup-c' name='change_interns_listId[]' class='ms' multiple='multiple' required>";
            foreach ($old_interns as $oi) {
//                            for ($i=0; $i< $tot_old_int; $i++) {
//                                $oi = $old_interns[$i];
                $formatted_created_at = new DateTime($oi['created_at']);
                $created_at_date = $formatted_created_at->format('M d, Y');

                if(!in_array($created_at_date,$created_at_row)){
                    echo "<optgroup label='$created_at_date'>";
                    $created_at_row[]=$created_at_date;
                }
                echo "<option value='$oi[uid]'>$oi[full_name]</option>";

                $oi1 = $old_interns[$i+1];
                $formatted_created_at = new DateTime($oi1['created_at']);
                $created_at_date = $formatted_created_at->format('M d, Y');
                if(!in_array($created_at_date,$created_at_row)){
                    echo "</optgroup>";
                }

            }
    echo "</select>";
    echo "</div>";
    unset($_REQUEST['fetch_batch_interns']);
return;
}

// TO FETCH INTERNS For Team
if(isset($_REQUEST['fetch_batch_interns_for_team']) && $_REQUEST['fetch_batch_interns_for_team']==1){
    $batch_id_from = $_REQUEST['batch_id_from'];

    $created_at_row = array();
    $team_interns = getAllInternsToCreateTeam($batch_id_from) ;
    $tot_old_int = count($team_interns);
//var_dump($team_interns);
    echo "<div class='col-sm-6 col-md-6'>
                <label for='optgroup'> SELECT OLD INTERNS   ( $tot_old_int  )</label>
            </div>
            <div class='col-sm-6 col-md-6'>
                <li style='text-align: right'>
                    <a href='#' id='select-all-c'>select all</a>
                    <a href='#' style='padding-left: 10px' id='deselect-all-c'>deselect all</a>
                </li>
            </div>
        ";
    echo "<div class='col-sm-12 col-md-12'>";
    echo "<select id='optgroup-c' name='change_interns_listId[]' class='ms' multiple='multiple' required>";
    foreach ($team_interns as $ti) {
//                            for ($i=0; $i< $tot_old_int; $i++) {
//                                $ti = $team_interns[$i];
        $formatted_created_at = new DateTime($ti['created_at']);
        $created_at_date = $formatted_created_at->format('M d, Y');

        if(!in_array($created_at_date,$created_at_row)){
            echo "<optgroup label='$created_at_date'>";
            $created_at_row[]=$created_at_date;
        }
        echo "<option value='$ti[uid]'>$ti[full_name] - $ti[team_name]</option>";

        $ti1 = $team_interns[$i+1];
        $formatted_created_at = new DateTime($ti1['created_at']);
        $created_at_date = $formatted_created_at->format('M d, Y');
        if(!in_array($created_at_date,$created_at_row)){
            echo "</optgroup>";
        }

    }
    echo "</select>";
    echo "</div>";
    unset($_REQUEST['fetch_batch_interns']);
    return;
}

// TO FETCH BATCH TO CHANGE TO
if(isset($_REQUEST['fetch_batch_to']) && $_REQUEST['fetch_batch_to']==1){
    $batch_id_from = $_REQUEST['batch_id_from'];

    $today_date_string = new DateTime();
    $today_date_normal = $today_date_string->format('Y-m-d');

    $ongoingBatches_to = getAllOngoingBatchesExcept($today_date_normal, $batch_id_from);
    $tot_ongoing_batch_to = count($ongoingBatches_to);

    echo "<label for='batch_id_to'>TO ( $tot_ongoing_batch_to ) </label>";
    echo"<select id='batch_id_to' name='batch_id_to' class='form-control show-tick' required>
            <option value=''>SELECT NEW BATCH</option>";

            foreach ($ongoingBatches_to as $ob) {
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

    echo "</select>";

    unset($_REQUEST['fetch_batch_to']);
    return;
}

// ATTENDANCE GET INTERNS
if(isset($_REQUEST['fetch_attendance_interns']) && $_REQUEST['fetch_attendance_interns']==1){

    $batch_id_from = $_REQUEST['batch_id_from'];
    $attendance_date = $_REQUEST['attendance_date'];

    $created_at_row = array();
    $interns_atd = getAllInternsForAttendance($batch_id_from) ;
    $tot_old_int = count($interns_atd);

    echo "<style type='text/css'>
     .table-bordered tbody tr td, .table-bordered tbody tr th {
        border: 3px solid #5F9EA0 !important;
     } </style>";

    echo "<table class='table-bordered' width='100%' style=' padding-top: 20px; line-height: 30px; letter-spacing: 0.3px; font-size: 16px;  color:#333; '>";

    echo "<tr style='font-weight:bold; color: whitesmoke; background: cadetblue '> 
        <td>&nbsp;S.No.</td> 
        <td>&nbsp;Email</td>  
        <td>&nbsp;Name</td>
        <td>&nbsp;Status</td>
        ";
    echo " </tr>";

    $atn_dates = getAllAtnDateToCheck($attendance_date);

    $pre_val1=present;
    $abs_val2=absent;
    $i=0;

    $past_interns = getAllInternsForAttendanceOfPastDate($attendance_date, $batch_id_from);

    $do_old = 0;
    if(!empty($past_interns)){
        $interns_atd = $past_interns;
        $do_old = 1;
    }

    foreach ($interns_atd as $itd) {
//     for ($i=0; $i< $tot_old_int; $i++) {
//        $itd = $interns_atd[$i];
        $i++;
        $bg_row = 'bgwht';
        $present_selected = 'selected';
        $absent_selected = '';
        $update_index = 0;

        if($do_old){
//        if(in_array($attendance_date, array_column($atn_dates,'atn_date'))){
//            $intern_atd_row = getInternAttendance($attendance_date, $itd['uid']);
            $intern_atd_row=$itd;
            if(!empty($intern_atd_row)){
                $filled_string = "Attendance Already Filled!";
                    if($intern_atd_row['status'] == $pre_val1){
                        $bg_row = 'bgblue';
                        $present_selected = 'selected';
                    }elseif ($intern_atd_row['status'] == $abs_val2){
                        $bg_row = 'bgred';
                        $present_selected='';
                        $absent_selected = 'selected';
                    }

                $update_index = 1;
                echo "<input type='hidden' name='update_rd_$i' id='update_rd_$i' value='$intern_atd_row[baid]' />";
            }
        }

        echo "<tr class='$bg_row' id='sel_$i' style='color: blue; font-weight:bold;'>";

        echo "<td >  &nbsp; ".$i."</td>";
        echo "<td>  &nbsp; ".$itd['email']."</td>";
        echo "<td> &nbsp; ". $itd['full_name'] ."
                  <input type='hidden' style='max-width:20px;' name='intern_".$i."' value='".$itd['uid']."'
              </td>";

        echo "<td  style='max-width:150px;'>
                <select class='form-control vp' onchange='cons(this.value, this.id);'  id='$i' name='status_$i' >
                    <option value=$pre_val1  $present_selected>Present</option>
                    <option value=$abs_val2  $absent_selected>Absent</option>
                </select>  
            </td>";

//        echo "<td  style='max-width:150px;'>
//                <div class='switch'>
//                    <label>ABSENT<input type='checkbox' checked=''><span class='lever switch-col-green'></span>PRESENT</label>
//                </div>
//            </td>";

        echo "<input type='hidden' name='update_index_$i' id='update_index_$i' value='$update_index' />";


//        <input class='sel_".$i." vp' type='hidden' name='consol_".$i."' value='1'>
        echo "</tr>";

    }
    echo "</table>";

    echo "<input type='hidden' name='totalRows' id='totalRowsID' value='$i' />";


    echo "<div class='col-sm-12 col-md-8' style='padding:0px; margin-top: 25px; '>
    <p style='font-size: 18px;'>  Present: <span id='prs' style='font-weight:bold; color:green;'> $i </span> / Absent:  <span id='abs' style='font-weight:bold; color:red;'> 0 </span></p>
    </div>";

    echo "<div class='col-sm-12 col-md-4'  style='padding:0px; margin-top: 25px; '>
        <button type='submit' name='submit_attendance' id='submit_attendance' class='btn btn-block btn-large bg-teal
         waves-effect' style='font-size: 16px; letter-spacing: 1px; background: #5F9EA0 '>SAVE</button>
        </div>";

    unset($_REQUEST['fetch_attendance_interns']);
    $_REQUEST['fetch_attendance_interns']=0;
    return;
}

// ATTENDANCE INSERT
if(isset($_REQUEST['submit_attendance'])){

    if(empty($_REQUEST['batch_id']) || empty($_REQUEST['date_']) || empty($_REQUEST['totalRows'])){
        $_SESSION['msg'] = "All the fields are required!";;
        $_SESSION['msg_color'] = 'bg-teal';
        return ;
    }

    $batch_id = $_REQUEST['batch_id'];
    $date_ = $_REQUEST['date_'];
    $totalRows = $_REQUEST['totalRows'];

    $result = array();
    $tot_interns_added=0;
    $error_in_count=0;

    for ($i=1; $i<=$totalRows; $i++) {
        $intern_id = $_POST['intern_' . $i];
        $intern_atd_status = $_POST['status_' . $i];
        $intern_update_status = $_POST['update_index_' . $i];

        if($intern_update_status==1){
            $atn_row_id = $_POST['update_rd_' . $i];
            $result[$intern_id] = updateInternAttendance($intern_atd_status, $userId, $atn_row_id);
        }else{
            $result[$intern_id] = insertInternAttendance($date_, $batch_id, $intern_id, $intern_atd_status, $userId);
        }

        if ( $result[$intern_id] == true){
            $tot_interns_added++;
        }else{
            $error_in_count++;
        }

    }

    if($tot_interns_added == $totalRows){
        $_SESSION['msg'] = $tot_interns_added." Interns Attendance Filled";
        $_SESSION['msg_color'] =  'alert-success';
    }else{
        $_SESSION['msg'] = 'Error!! '.$error_in_count.' This Much Interns Attendance Not Filled.';
        $_SESSION['msg_color'] =  'alert-danger';
    }

    unset($_REQUEST['submit_attendance']);
    return;
}

if(isset( $_REQUEST['add_teams'] ) ){


    $team_name = $_REQUEST['team_name'];

    $oldTeam_name = checkTeamName($team_name);
    // if request is from javascript to check validation of uniqueness and error is found
    if (!empty($oldTeam_name['team_name']) && $oldTeam_name['team_name'] === $team_name) { // if user exists
        $_SESSION['msg'] = "Team Name already exists";
        $_SESSION['msg_color'] = 'bg-orange';
        echo "false";
        return;
    }
// if request is from javascript to check validation and no error is found
    if(isset($_REQUEST['checkunique']) && $_REQUEST['checkunique']=="yes" ){
        echo "true";
        return;
    }

    if(empty($_REQUEST['team_name']) || empty($_REQUEST['batch_id_from'])  || empty($_REQUEST['change_interns_listId'])){
        $_SESSION['msg'] = "All the fields are required! Except Project Name";
        $_SESSION['msg_color'] = 'bg-teal';
        return ;
    }

    $team_name = ucwords($team_name);
    $batch_id_from = $_REQUEST['batch_id_from'];
    $change_interns_listId = $_REQUEST['change_interns_listId'];
    $total_interns_selected = count($change_interns_listId);

    // Inserting the New Team and getting team id
    $team_id = insertTeam($team_name,$batch_id_from,$userId);

    $result = array();
    $tot_interns_added=0;
    $error_in_count=0;

    foreach ($change_interns_listId as $sid){
        $result[$sid] = insertTeamInterns($team_id,$sid,$userId);
        if ( $result[$sid] == true){
            $tot_interns_added++;
        }else{
            $error_in_count++;
        }
    }
    $msg2='';
    if(!empty($_REQUEST['project_name'])){
        $project_name = $_REQUEST['project_name'];
        $project_name = ucwords($project_name);
        $proj_id = insertProject($project_name,$userId);
        insertTeamProject($proj_id,$team_id);
        $msg2 = "PROJECT-".$project_name."- Created and Assigned to Team-".$team_name."-";
    }

    if($tot_interns_added == $total_interns_selected){
        $_SESSION['msg'] = "TEAM-".$team_name."- with ".$tot_interns_added ." Members Created Successfully"."<br>".$msg2;
        $_SESSION['msg_color'] =  'alert-success';
    }else{
        $error_in_c = $total_interns_selected-$tot_interns_added ;
        $_SESSION['msg'] = 'Error!! '.$error_in_count.' This Much Interns Not Added in Team.';
        $_SESSION['msg_color'] =  'alert-danger';
    }

    unset($_REQUEST['add_teams']);

    return;
}

if(isset( $_REQUEST['add_project'] ) ){

    $project_name_c = $_REQUEST['project_name_c'];

    $oldProject_name_c = checkProjectName($project_name_c);
    // if request is from javascript to check validation of uniqueness and error is found
    if (!empty($oldProject_name_c['project_name']) && $oldProject_name_c['project_name'] === $project_name_c) { // if user exists
        $_SESSION['msg'] = "Project Name already exists";
        $_SESSION['msg_color'] = 'bg-orange';
        echo "false";
        return;
    }
// if request is from javascript to check validation and no error is found
    if(isset($_REQUEST['checkunique']) && $_REQUEST['checkunique']=="yes" ){
        echo "true";
        return;
    }

    if(empty($_REQUEST['team_id']) || empty($_REQUEST['project_name_c']) ){
        $_SESSION['msg'] = "All the fields are required!";
        $_SESSION['msg_color'] = 'bg-teal';
        return ;
    }

    $team_id = $_REQUEST['team_id'];
    $project_name_c = ucwords($project_name_c);


    $proj_id = insertProject($project_name_c,$userId);
    $result = insertTeamProject($proj_id,$team_id);

    if($result){
        $_SESSION['msg'] = "PROJECT -".$project_name_c."- Created and Assigned to Team";
        $_SESSION['msg_color'] =  'alert-success';
    }else{
        $_SESSION['msg'] = 'Error!! .';
        $_SESSION['msg_color'] =  'alert-danger';
    }
    unset($_REQUEST['add_project']);
    return;
}

// datatable show all batches
if(isset($_REQUEST['dtShowAllBatches']) && $_REQUEST['dtShowAllBatches']=='batch_list') {

    $batches = getAllHistoryBatches();
//    $data[] = "data";
    $tot_allBatches = count($batches);
    $data = array();
    for ($i = 0; $i < $tot_allBatches; $i++) {
//    foreach ($all_users as $au) {
        $ob=$batches[$i];

        $df = new DateTime($ob['from_d_b']);
        $formatted_date_f = $df->format('M, d Y');
        $formatted_date_f_normal = $df->format('d-m-Y');

        $dt = new DateTime($ob['to_d_b']);
        $formatted_date_t = $dt->format('M, d Y');
        $formatted_date_t_normal = $dt->format('d-m-Y');

        $interval = $df->diff($dt);
        $noOfD =  $interval->format('%m months, %R%d days');

        $d = new DateTime($ob['created_at']);
        $formatted_date = $d->format('M, d Y');
        $formatted_time = $d->format('h:i A');


        $data[$i]['batch_name']=$ob['batch_name']." (".$ob['batch_year'].") " ;
        $data[$i]['number_of_interns']=$ob['number_of_interns'];
        $data[$i]['created_by_name']=$ob['created_by_name'];
        $data[$i]['created_at']=$formatted_date . " " . $formatted_time ;
        $data[$i]['duration']=$formatted_date_f." - ".$formatted_date_t." (".$noOfD.")";
        $data[$i]['bid']=$ob['bid'];

        $url_page ="batch_ind_home.php?bid=$ob[bid]";
        $data[$i]['url']=$url_page ;
    } // end of for loop

    $results = array(
        "TotalRecords" => count($batches),
        "data"=>$data
    );
    echo json_encode($results);
    return;
}

// datatable show all projects
if(isset($_REQUEST['dtShowAllProjects']) && $_REQUEST['dtShowAllProjects']=='projects_list') {

    $projects = getAllHistoryProject();
//    $data[] = "data";
    $tot_allProjects = count($projects);
    $data = array();
    for ($i = 0; $i < $tot_allProjects; $i++) {
//    foreach ($all_users as $au) {
        $pj=$projects[$i];

        $d = new DateTime($pj['project_timestamp']);
        $formatted_date = $d->format('M, d Y');
        $formatted_time = $d->format('h:i A');

        $df = new DateTime($pj['from_d_b']);
            $formatted_date_f = $df->format('M, d Y');
            $formatted_date_f_normal = $df->format('d-m-Y');
        $dt = new DateTime($pj['to_d_b']);
            $formatted_date_t = $dt->format('M, d Y');
            $formatted_date_t_normal = $dt->format('d-m-Y');
        $interval = $df->diff($dt);
        $noOfD =  $interval->format('%m months, %R%d days');

        $data[$i]['project_name']=$pj['project_name']." (".$pj['batch_year'].") ";
        $data[$i]['team_name']=$pj['team_name'];
        $data[$i]['num_members']=$pj['num_members'];
        $data[$i]['created_at']=$formatted_date . " " . $formatted_time ;
        $data[$i]['batch_name']= $pj['batch_name']." (".$pj['batch_year'].") ".$formatted_date_f." - ".$formatted_date_t." (".$noOfD.")";
        $data[$i]['bid']=$pj['bid'];
        $data[$i]['pid']=$pj['pid'];

        $url_page ="project_ind_home.php?pid=$pj[pid]";
        $data[$i]['url']=$url_page ;

    } // end of for loop

    $results = array(
        "TotalRecords" => count($projects),
        "data"=>$data
    );
    echo json_encode($results);
    return;
}

if(isset($_REQUEST['dtShowAllProjectsTeam']) && $_REQUEST['dtShowAllProjectsTeam']=='projects_list') {
    $team_id = $_REQUEST['team_id'];
    $projects = getAllOnGoingProjectOfTeam($team_id);
//    $data[] = "data";
    $tot_allProjects = count($projects);
    $data = array();
    for ($i = 0; $i < $tot_allProjects; $i++) {
//    foreach ($all_users as $au) {
        $pj=$projects[$i];

        $d = new DateTime($pj['project_timestamp']);
        $formatted_date = $d->format('M, d Y');
        $formatted_time = $d->format('h:i A');

        $df = new DateTime($pj['from_d_b']);
            $formatted_date_f = $df->format('M, d Y');
            $formatted_date_f_normal = $df->format('d-m-Y');
        $dt = new DateTime($pj['to_d_b']);
            $formatted_date_t = $dt->format('M, d Y');
            $formatted_date_t_normal = $dt->format('d-m-Y');
        $interval = $df->diff($dt);
            $noOfD =  $interval->format('%m months, %R%d days');

        $c_status_color = 'blue';
        if ($pj['project_status'] == pj_pending) {
            $c_status_color = 'col-blue';
            $string_s = 'PENDING';
        } else if ($pj['project_status'] == pj_dismissed ) {
            $c_status_color = 'col-orange';
            $string_s = 'DISMISSED';
        }else if ($pj['project_status'] == pj_completed ) {
            $c_status_color = 'col-green';
            $string_s = 'COMPLETED';
        }

        $data[$i]['project_name']=$pj['project_name']." (".$pj['batch_year'].") ";
        $data[$i]['team_name']=$pj['team_name'];
        $data[$i]['num_members']=$pj['num_members'];
        $data[$i]['created_at']=$formatted_date . " " . $formatted_time ;
//        $data[$i]['batch_name']= $pj['batch_name']." (".$pj['batch_year'].") ".$formatted_date_f." - ".$formatted_date_t." (".$noOfD.")";
        $data[$i]['pid']=$pj['pid'];

        $data[$i]['dt_row_color_class']=$c_status_color;
        $data[$i]['pj_status']=$string_s;

        $url_page ="project_ind_home.php?pid=$pj[pid]";
        $data[$i]['url']=$url_page ;

    } // end of for loop

    $results = array(
        "TotalRecords" => count($projects),
        "data"=>$data
    );
    echo json_encode($results);
    return;
}

if(isset($_REQUEST['dtShowAllTeams']) && $_REQUEST['dtShowAllTeams']=='team_lists') {

    $teams = getAllHistoryTeams();
//    $data[] = "data";
    $tot_allTeams = count($teams);
    $data = array();
    for ($i = 0; $i < $tot_allTeams; $i++) {
//    foreach ($all_users as $au) {
        $tm=$teams[$i];

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

        $data[$i]['team_name']=$tm['team_name']." (".$tm['batch_year'].") ";
        $data[$i]['num_members']=$tm['num_members'];
        $data[$i]['num_projects']=$tm['num_projects'];
        $data[$i]['created_at']=$formatted_date . " " . $formatted_time ;
        $data[$i]['batch_name']= $tm['batch_name']." (".$tm['batch_year'].") ".$formatted_date_f." - ".$formatted_date_t." (".$noOfD.")";

        $url_page ="team_ind_home.php?tid=$tm[tid]";
        $data[$i]['url']=$url_page ;

    } // end of for loop

    $results = array(
        "TotalRecords" => count($teams),
        "data"=>$data
    );
    echo json_encode($results);
    return;
}

if(isset($_REQUEST['dtShowAllTeamsBatch']) && $_REQUEST['dtShowAllTeamsBatch']=='team_lists_batch') {

    $batch_id = $_REQUEST['batch_id'];
    $teams = getAllOnGoingTeamsOfBatch($batch_id);
//    $data[] = "data";
    $tot_allTeams = count($teams);
    $data = array();
    for ($i = 0; $i < $tot_allTeams; $i++) {
//    foreach ($all_users as $au) {
        $tm=$teams[$i];

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

        $data[$i]['team_name']=$tm['team_name']." (".$tm['batch_year'].") ";
        $data[$i]['num_members']=$tm['num_members'];
        $data[$i]['num_projects']=$tm['num_projects'];
        $data[$i]['created_at']=$formatted_date . " " . $formatted_time ;
        $data[$i]['created_by_name_team']= $tm['created_by_name_team'];

        $url_page ="team_ind_home.php?tid=$tm[tid]";
        $data[$i]['url']=$url_page ;

    } // end of for loop

    $results = array(
        "TotalRecords" => count($teams),
        "data"=>$data
    );
    echo json_encode($results);
    return;
}

if (isset($_REQUEST['project_status_submit'])) {

    if (empty($_REQUEST['pid']) || empty($_REQUEST['project_s_option']) ) {
        $_SESSION['msg'] = "All the fields are required!";
        $_SESSION['msg_color'] = 'bg-teal';
        return;
    }

    $project_s_option = $_REQUEST['project_s_option'];
    $pid = $_REQUEST['pid'];
    $project_name = $_REQUEST['project_name'];

    $result = updateProjectStatus($project_s_option, $pid );

    if ($result) {
        $_SESSION['msg'] = "PROJECT - " . $project_name . " - status updated";
        $_SESSION['msg_color'] = 'alert-success';
    } else {
        $_SESSION['msg'] = 'Error!! ';
        $_SESSION['msg_color'] = 'alert-danger';
    }
//    echo ("<script language='javascript'>
//           window.location.href='task_show.php?pid='+$pid;
//        </script>");
    return;
}