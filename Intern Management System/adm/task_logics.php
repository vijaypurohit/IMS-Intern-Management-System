<?php
/**
 * Created by PhpStorm.
 * User: Vijay Purohit
 * Date: 14-Jun-19
 * Time: 2:41 PM
 * Project: ims_vj
 */

$asset_path_link='../';

require_once($asset_path_link.'config.php');

require_once(INCLUDE_PATH . "/logic/common_functions.php");

$user_s = $_SESSION['user'];
$userId = $user_s['id'];

// status
const tsk_enable=1;  // enable in progress
const tsk_disable=-1;   // dimissed by admin
const tsk_completed=2;  // task completed by user
// notify
const tsk_inspection = 1;  // task is send to user and not seen
const tsk_inspectionViewed = -1;  // task seen by user

const tsk_request = 1;  // task inspection is send to admin and not seen
const tsk_requestViewed = -1;  // task inspection seen by admin


if (isset($_SESSION['form_token']) && isset($_POST['form_token']) && ($_POST['form_token'] != $_SESSION['form_token'] ) ) {
    $_SESSION['msg'] = "Form Submitted Already";
    $_SESSION['msg_color'] = 'bg-blue';
    return;
}


function dataready($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_REQUEST['add_task'])) {

    if (empty($_REQUEST['batch_id_from']) || empty($_REQUEST['task_name']) || empty($_REQUEST['task_desc']) || empty($_REQUEST['change_interns_listId'])) {
        $_SESSION['msg'] = "All the fields are required!";
        $_SESSION['msg_color'] = 'bg-teal';
        return;
    }

    $batch_id_from = $_REQUEST['batch_id_from'];
    $task_name = $_REQUEST['task_name'];
    $task_name = ucwords($_REQUEST['task_name']);
    $task_desc = $_REQUEST['task_desc'];
    $interns_listId = $_REQUEST['change_interns_listId'];
    $total_interns_selected = count($interns_listId);

    $deadline_task_string_time = NULL;
    if (!empty($_REQUEST['deadline_task'])) {
        $deadline_task = $_REQUEST['deadline_task'];
        try {
            $deadline_task_string = new DateTime($deadline_task);
        } catch (Exception $e) {
            error_log($e->getMessage());
            $_SESSION['msg'] = "Hey, Developer here, You can't select dates like that";
            $_SESSION['msg_color'] = 'bg-orange';
            return;
        }
        $deadline_task_string_time = $deadline_task_string->format('Y-m-d');
    }

    $project_id = NULL;
    if (!empty($_REQUEST['project_row_id'])) {
        $project_id = $_REQUEST['project_row_id'];
    }

    $task_desc= dataready($task_desc);
//    var_dump($batch_id_from);
//    var_dump($task_name);
//    var_dump($task_desc);
//    var_dump($project_id);
//    var_dump($deadline_task_string_time);

//html_entity_decode($article_text);
//    var_dump(html_entity_decode($task_desc));

    $result = array();
    $tot_interns_added = 0;
    $error_in_count = 0;

    foreach ($interns_listId as $sid) {
        $result[$sid] = insertTask($batch_id_from, $sid, $userId, $task_name, $task_desc, $project_id, $deadline_task_string_time);
        if ($result[$sid] == true) {
            $tot_interns_added++;
        } else {
            $error_in_count++;
        }
    }

    if ($tot_interns_added == $total_interns_selected) {
        $_SESSION['msg'] = "TASK -" . $task_name . "- Created and Assigned to " . $tot_interns_added . " Members ";
        $_SESSION['msg_color'] = 'alert-success';
    } else {
        $error_in_c = $total_interns_selected - $tot_interns_added;
        $_SESSION['msg'] = 'Error!! ' . $error_in_count . ' This Much Interns are not assigned task.';
        $_SESSION['msg_color'] = 'alert-danger';
    }

    unset($_REQUEST['add_task']);
    return;
}

// show all tasks
if(isset($_REQUEST['dtShowAllTasks']) && $_REQUEST['dtShowAllTasks']=='task_list') {
//    $year_check='2019';
    $year_check=$_REQUEST['selectedYear'];
//    $all_users = getUserRoleProfileOfAll();
    $all_tasks = getAllTasks();
//var_dump($allUsers_all_leaves);
//var_dump($year_check);
//var_dump($userId);
    $tot_all_tasks = count($all_tasks);
    $data = array();
    for ($i = 0; $i < $tot_all_tasks; $i++) {
//    foreach ($all_users as $at) {
        $at=$all_tasks[$i];


        $date_addD = new DateTime($at['created_at']);
        $date_add_formatted_date = $date_addD->format('M, d Y');
        $date_add_formatted_time = $date_addD->format('h:i A');

        $tkid = $at['tkid'];
        $intern_id = $at['intern_id'];
        $from_id = $at['from_id'];
        $title_ = $at['title_'];
        $desc_= $at['desc_'];
        $project_id= $at['project_id'];
        $project_name= $at['project_name'];
        $deadline= $at['deadline'];
        $notify= $at['notify'];
        $intern_name= $at['intern_name'];
        $created_by_name= $at['created_by_name'];

        $approved_string = $notify == 1 ? 'NOT SEEN' : 'SEEN';
        $notify_string_color = $notify == tsk_inspection ? 'col-red' : ($notify == tsk_inspectionViewed ? 'col-green' : 'col-yellow');


        $c_status_color = 'col-blue';
        if ($at['status'] == tsk_enable) {
            $c_status_color = 'col-orange';
            $string_s = 'PENDING';
        } else if ($at['status'] == tsk_disable ) {
            $c_status_color = 'col-red';
            $string_s = 'DISMISSED';
        }else if ($at['status'] == tsk_completed ) {
            $c_status_color = 'col-green';
            $string_s = 'COMPLETED';
        }

//        $data[$i]['formatted_approved']=$approved_timeD_formatted_date . " | " . $approved_timeD_formatted_time;
        $data[$i]['intern_name']=$intern_name ;
        $data[$i]['tk_title']=$title_;
        $data[$i]['tk_project']=$project_name;
        $data[$i]['tk_status']=$string_s;
        $data[$i]['formatted_initiate']=$date_add_formatted_date . " | " . $date_add_formatted_time;

        $data[$i]['dt_row_color_class']=$notify_string_color;
        $data[$i]['tk_status_color']=$c_status_color;

//        $url = urlencode(serialize($at));
//        $url_page ="task_show.php?tkid=$url";
//        $data[$i]['url']=$url_page ;
        $url_page ="task_show.php?tkid=$tkid";
        $data[$i]['url']=$url_page ;

    } // end of for loop

    $results = array(
        "TotalRecords" => count($all_tasks),
        "data"=>$data
    );
    echo json_encode($results);
    exit;
}

if(isset($_REQUEST['dtShowAllTasksPending']) && $_REQUEST['dtShowAllTasksPending']=='Pending') {
//    $year_check='2019';
    $year_check=$_REQUEST['selectedYear'];
//    $all_users = getUserRoleProfileOfAll();
    $all_tasks = getAllTasksAccToStatus(tsk_enable);
//var_dump($allUsers_all_leaves);
//var_dump($year_check);
//var_dump($userId);
    $tot_all_tasks = count($all_tasks);
    $data = array();
    for ($i = 0; $i < $tot_all_tasks; $i++) {
//    foreach ($all_users as $at) {
        $at=$all_tasks[$i];


        $date_addD = new DateTime($at['created_at']);
        $date_add_formatted_date = $date_addD->format('M, d Y');
        $date_add_formatted_time = $date_addD->format('h:i A');

        $tkid = $at['tkid'];
        $intern_id = $at['intern_id'];
        $from_id = $at['from_id'];
        $title_ = $at['title_'];
        $desc_= $at['desc_'];
        $project_id= $at['project_id'];
        $project_name= $at['project_name'];
        $deadline= $at['deadline'];
        $notify= $at['notify'];
        $intern_name= $at['intern_name'];
        $created_by_name= $at['created_by_name'];

        $approved_string = $notify == 1 ? 'NOT SEEN' : 'SEEN';
        $notify_string_color = $notify == tsk_inspection ? 'col-red' : ($notify == tsk_inspectionViewed ? 'col-green' : 'col-yellow');


        $c_status_color = 'col-blue';
        if ($at['status'] == tsk_enable) {
            $c_status_color = 'col-orange';
            $string_s = 'PENDING';
        } else if ($at['status'] == tsk_disable ) {
            $c_status_color = 'col-red';
            $string_s = 'DISMISSED';
        }else if ($at['status'] == tsk_completed ) {
            $c_status_color = 'col-green';
            $string_s = 'COMPLETED';
        }

//        $data[$i]['formatted_approved']=$approved_timeD_formatted_date . " | " . $approved_timeD_formatted_time;
        $data[$i]['intern_name']=$intern_name ;
        $data[$i]['tk_title']=$title_;
        $data[$i]['tk_project']=$project_name;
        $data[$i]['tk_status']=$string_s;
        $data[$i]['formatted_initiate']=$date_add_formatted_date . " | " . $date_add_formatted_time;

        $data[$i]['dt_row_color_class']=$notify_string_color;
        $data[$i]['tk_status_color']=$c_status_color;

//        $url = urlencode(serialize($at));
//        $url_page ="task_show.php?tkid=$url";
//        $data[$i]['url']=$url_page ;
        $url_page ="task_show.php?tkid=$tkid";
        $data[$i]['url']=$url_page ;

    } // end of for loop

    $results = array(
        "TotalRecords" => count($all_tasks),
        "data"=>$data
    );
    echo json_encode($results);
    exit;
}

if(isset($_REQUEST['dtShowAllTasksOfProject']) && $_REQUEST['dtShowAllTasksOfProject']=='task_list_project') {
//    $year_check='2019';
    $project_id=$_REQUEST['project_id'];
//    $all_users = getUserRoleProfileOfAll();
    $all_tasks = getAllTasksOfProject($project_id);
//var_dump($allUsers_all_leaves);
//var_dump($year_check);
//var_dump($userId);
    $tot_all_tasks = count($all_tasks);
    $data = array();
    for ($i = 0; $i < $tot_all_tasks; $i++) {
//    foreach ($all_users as $at) {
        $at=$all_tasks[$i];


        $date_addD = new DateTime($at['created_at']);
        $date_add_formatted_date = $date_addD->format('M, d Y');
        $date_add_formatted_time = $date_addD->format('h:i A');

        $tkid = $at['tkid'];
        $intern_id = $at['intern_id'];
        $from_id = $at['from_id'];
        $title_ = $at['title_'];
        $desc_= $at['desc_'];
        $project_id= $at['project_id'];
        $project_name= $at['project_name'];
        $deadline= $at['deadline'];
        $notify= $at['notify'];
        $intern_name= $at['intern_name'];
        $created_by_name= $at['created_by_name'];

        $approved_string = $notify == 1 ? 'NOT SEEN' : 'SEEN';
        $notify_string_color = $notify == tsk_inspection ? 'col-red' : ($notify == tsk_inspectionViewed ? 'col-green' : 'col-yellow');


        $c_status_color = 'col-blue';
        if ($at['status'] == tsk_enable) {
            $c_status_color = 'col-orange';
            $string_s = 'PENDING';
        } else if ($at['status'] == tsk_disable ) {
            $c_status_color = 'col-red';
            $string_s = 'DISMISSED';
        }else if ($at['status'] == tsk_completed ) {
            $c_status_color = 'col-green';
            $string_s = 'COMPLETED';
        }

//        $data[$i]['formatted_approved']=$approved_timeD_formatted_date . " | " . $approved_timeD_formatted_time;
        $data[$i]['intern_name']=$intern_name ;
        $data[$i]['tk_title']=$title_;
        $data[$i]['tk_project']=$project_name;
        $data[$i]['tk_status']=$string_s;
        $data[$i]['formatted_initiate']=$date_add_formatted_date . " | " . $date_add_formatted_time;

        $data[$i]['dt_row_color_class']=$notify_string_color;
        $data[$i]['tk_status_color']=$c_status_color;

        $url = urlencode(serialize($at));
//        $url_page ="task_show.php?tkid=$url";
//        $data[$i]['url']=$url_page ;
        $url_page ="task_show.php?tkid=$tkid";
        $data[$i]['url']=$url_page ;
//        $data[$i]['tkid']=$tkid ;

    } // end of for loop

    $results = array(
        "TotalRecords" => count($all_tasks),
        "data"=>$data
    );
    echo json_encode($results);
    exit;
}

if(isset($_REQUEST['dtShowUserTasks']) && $_REQUEST['dtShowUserTasks']=='task_list') {
//    $year_check='2019';
    $year_check=$_REQUEST['selectedYear'];
    $user_id=$_REQUEST['user_id'];
//    $all_users = getUserRoleProfileOfAll();$userId
    $all_tasks = getOnlyUserTasks($user_id);
//var_dump($allUsers_all_leaves);
//var_dump($year_check);
//var_dump($userId);
    $tot_all_tasks = count($all_tasks);
    $data = array();
    for ($i = 0; $i < $tot_all_tasks; $i++) {
//    foreach ($all_users as $at) {
        $at=$all_tasks[$i];


        $date_addD = new DateTime($at['created_at']);
        $date_add_formatted_date = $date_addD->format('M, d Y');
        $date_add_formatted_time = $date_addD->format('h:i A');

        $tkid = $at['tkid'];
        $intern_id = $at['intern_id'];
        $from_id = $at['from_id'];
        $title_ = $at['title_'];
        $desc_= $at['desc_'];
        $project_id= $at['project_id'];
        $project_name= $at['project_name'];
        $deadline= $at['deadline'];
        $notify= $at['notify'];
        $intern_name= $at['intern_name'];
        $created_by_name= $at['created_by_name'];
        $team_name= $at['team_name'];

        $approved_string = $notify == 1 ? 'NOT SEEN' : 'SEEN';
        $notify_string_color = $notify == tsk_inspection ? 'col-red' : ($notify == tsk_inspectionViewed ? 'col-green' : 'col-yellow');


        $c_status_color = 'col-blue';
        if ($at['status'] == tsk_enable) {
            $c_status_color = 'col-orange';
            $string_s = 'PENDING';
        } else if ($at['status'] == tsk_disable ) {
            $c_status_color = 'col-red';
            $string_s = 'DISMISSED';
        }else if ($at['status'] == tsk_completed ) {
            $c_status_color = 'col-green';
            $string_s = 'COMPLETED';
        }

//        $data[$i]['formatted_approved']=$approved_timeD_formatted_date . " | " . $approved_timeD_formatted_time;
        $data[$i]['tk_title']=$title_;
        $data[$i]['tk_project']=$project_name;
        $data[$i]['team_name']=$team_name ;
        $data[$i]['formatted_initiate']=$date_add_formatted_date . " | " . $date_add_formatted_time;
        $data[$i]['tk_status']=$string_s;

        $data[$i]['dt_row_color_class']=$notify_string_color;
        $data[$i]['tk_status_color']=$c_status_color;

//        $url = urlencode(serialize($at));
//        $url_page ="task_show.php?tkidShowPage=$url";
//        $data[$i]['url']=$url_page ;
        $url_page ="task_show.php?tkid=$tkid";
        $data[$i]['url']=$url_page ;

    } // end of for loop

    $results = array(
        "TotalRecords" => count($all_tasks),
        "data"=>$data
    );
    echo json_encode($results);
    exit;
}

if (isset($_REQUEST['task_status_submit'])) {

    if (empty($_REQUEST['task_tid']) || empty($_REQUEST['task_s_option']) ) {
        $_SESSION['msg'] = "All the fields are required!";
        $_SESSION['msg_color'] = 'bg-teal';
        return;
    }

    $task_s_option = $_REQUEST['task_s_option'];
    $task_tid = $_REQUEST['task_tid'];
    $title_ = $_REQUEST['title_'];

    $result = updateTaskStatus($task_s_option, tsk_inspectionViewed,$task_tid );

    if ($result) {
        $_SESSION['msg'] = "TASK -" . $title_ . " status updated";
        $_SESSION['msg_color'] = 'alert-success';
    } else {
        $_SESSION['msg'] = 'Error!! ';
        $_SESSION['msg_color'] = 'alert-danger';
    }

    $_REQUEST['tkid'] = $task_tid;
//    echo ("<script language='javascript'>
//           window.location.href='task_show.php?tkid='+$task_tid;
//        </script>");
    return;
}
//$arr_data= $_REQUEST['id'];
//$tcLeave = unserialize(urldecode($arr_data));

