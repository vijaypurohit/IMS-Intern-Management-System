<?php
/**
 * Created by PhpStorm.
 * User: Vijay Purohit
 * Date: 09-Jun-19
 * Time: 2:29 PM
 * Project: ims_vj
 */


$asset_path_link='../';
require_once($asset_path_link.'config.php');

require_once(INCLUDE_PATH . "/logic/common_functions.php");

$user_s = $_SESSION['user'];
$userId = $user_s['id'];

if (isset($_SESSION['form_token']) && isset($_POST['form_token']) && ($_POST['form_token'] != $_SESSION['form_token'] ) ) {
    $_SESSION['msg'] = "Form Submitted Already";
    $_SESSION['msg_color'] = 'bg-blue';
    return;
}

// to submit the leave
if(isset($_REQUEST['submit_leave'])){

    if(empty($_REQUEST['from_date']) || empty($_REQUEST['to_date'])  || empty($_REQUEST['leave_reason']) || empty($_REQUEST['form_token']) ){
        $_SESSION['msg'] = "All the fields are required!";
        $_SESSION['msg_color'] = 'bg-teal';
        return ;
    }

    $from_date = $_REQUEST['from_date'];
    $to_date = $_REQUEST['to_date'];
    $leave_reason = $_REQUEST['leave_reason'];

    try {
        $from_date_string = new DateTime($from_date);
    } catch (Exception $e) {
        error_log($e->getMessage());
        $_SESSION['msg'] = "Hey, Developer here, You can't select dates like that";
        $_SESSION['msg_color'] = 'bg-orange';
        return;
    }
    $from_date_time =  $from_date_string->format('Y-m-d');

    try {
        $to_date_string = new DateTime($to_date);
    } catch (Exception $e) {
        error_log($e->getMessage());
        $_SESSION['msg'] = "Hey, Developer here, You can't select dates like that";
        $_SESSION['msg_color'] = 'bg-orange';
        return;
    }
    $to_date_time =  $to_date_string->format('Y-m-d');

    if ($from_date_time > $to_date_time) {
        $_SESSION['msg'] = "Hey, Developer here, You can't select dates like that";
        $_SESSION['msg_color'] = 'bg-orange';
        return ;
    }

    $inserted_id = insertLeave($userId, $from_date_time, $to_date_time, $leave_reason);
    if($inserted_id){
        $_SESSION['msg'] = "Leave Submitted";
        $_SESSION['msg_color'] =  'alert-success';
            updateLeaveRequest(1,$inserted_id);
    }else{
        $_SESSION['msg'] = 'Error!!';
        $_SESSION['msg_color'] =  'alert-danger';
    }
    unset($_REQUEST['submit_leave']);
    return;
}

// to submit the approvals
//if(isset($_REQUEST['leave_approval'])) {
//
////    var_dump($_REQUEST);
//    if (empty($_REQUEST['leave_id']) || empty($_REQUEST['form_token'])) {
//        $_SESSION['msg'] = "All the fields are required!";
//        $_SESSION['msg_color'] = 'bg-teal';
//        return;
//    }
//    $leave_id = $_REQUEST['leave_id'];
//
//    if(isset($_REQUEST['leave_accepted'])){
//        $status = 1;
//        $string = "Accepted";
//    }elseif (isset($_REQUEST['leave_rejected'])){
//        $status = -1;
//        $string = "Rejected";
//    }
////    var_dump($leave_id);
////    var_dump($status);
////    var_dump($userId);
//
//    $result =  updateLeaveStatus($status,$userId, $leave_id );
//    if($result){
//        $_SESSION['msg'] = "Leave -".$string."";
//        $_SESSION['msg_color'] =  'alert-success';
//    }else{
//        $_SESSION['msg'] = 'Error!! ';
//        $_SESSION['msg_color'] =  'alert-danger';
//    }
//    unset($_REQUEST['leave_approval']);
//}

// show particular user leaves
if(isset($_REQUEST['dtShowUserLeaves']) && $_REQUEST['dtShowUserLeaves']=='leave_list') {
//    $year_check='2019';
    $year_check=$_REQUEST['selectedYear'];
//    $all_users = getUserRoleProfileOfAll();
    $user_all_leaves = getUserLeave($userId, $year_check);
//var_dump($user_all_leaves);
//var_dump($year_check);
//var_dump($userId);
    $tot_allUsersLeaves = count($user_all_leaves);
    $data = array();
    for ($i = 0; $i < $tot_allUsersLeaves; $i++) {
//    foreach ($all_users as $ual) {
        $ual=$user_all_leaves[$i];


        $date_addD = new DateTime($ual['date_add']);
        $date_add_formatted_date = $date_addD->format('M, d Y');
        $date_add_formatted_time = $date_addD->format('h:i A');

        $from_ldateD = new DateTime($ual['from_ldate']);
        $from_ldate_formatted_date = $from_ldateD->format('M, d');

        $to_ldateD = new DateTime($ual['to_ldate']);
        $to_ldate_formatted_date = $to_ldateD->format('M, d');

        $interval = $from_ldateD->diff($to_ldateD);
        $noOfD =  $interval->format('%d');
        $noOfD =  (int)$noOfD+1;
        $date_str =  $noOfD>1?'days':'day';

        $approved_status = $ual['approved'];
        $approved_by_name= $ual['approved_by_name'];
        $reason= $ual['reason'];
        $approved_string = $approved_status == 1 ? 'APPROVED' : ($approved_status == -1 ? 'REJECTED' : 'PENDING');
        $approved_status_color = $approved_status == 1 ? 'col-green' : ($approved_status == -1 ? 'col-red' : 'col-orange');

        if($approved_by_name != null){
//            $approved_by_name = $approved_by_name;
            $approved_timeD = new DateTime($ual['approved_time']);
            $approved_timeD_formatted_date = $approved_timeD->format('M, d Y');
            $approved_timeD_formatted_time = $approved_timeD->format('h:i A');
            $le_approved_name = $approved_by_name." ".$approved_timeD_formatted_date . " | " . $approved_timeD_formatted_time;
        }else{
            $approved_timeD_formatted_date = '';
            $approved_timeD_formatted_time = '';
            $le_approved_name = 'NO-ONE';
        }

        $data[$i]['formatted_initiate']=$date_add_formatted_date . " | " . $date_add_formatted_time;
//        $data[$i]['formatted_approved']=$approved_timeD_formatted_date . " | " . $approved_timeD_formatted_time;
        $data[$i]['formatted_dateTime']=$from_ldate_formatted_date . " - " . $to_ldate_formatted_date." ( ".$noOfD." ".$date_str." )" ;
        $data[$i]['le_reason']=$reason;
        $data[$i]['le_status']=$approved_string;
        $data[$i]['le_approved_name']=$le_approved_name;

        $data[$i]['dt_row_color_class']=$approved_status_color ;
        $data[$i]['leave_id']=$ual['id'] ;

        $url_page ="intern_leave_ind_report.php?&leave_id=$ual[id]";
        $data[$i]['url']=$url_page ;


    } // end of for loop

    $results = array(
        "TotalRecords" => count($user_all_leaves),
        "data"=>$data
    );
    echo json_encode($results);
    exit;
}

// show all users leaves
//if(isset($_REQUEST['dtShowAllUsersLeaves']) && $_REQUEST['dtShowAllUsersLeaves']=='all_leave_list') {
////    $year_check='2019';
//    $year_check=$_REQUEST['selectedYear'];
////    $all_users = getUserRoleProfileOfAll();
//    $allUsers_all_leaves = getAllUsersLeaves($year_check);
////var_dump($allUsers_all_leaves);
////var_dump($year_check);
////var_dump($userId);
//    $tot_allUsersLeaves = count($allUsers_all_leaves);
//    $data = array();
//    for ($i = 0; $i < $tot_allUsersLeaves; $i++) {
////    foreach ($all_users as $ual) {
//        $ual=$allUsers_all_leaves[$i];
//
//
//        $date_addD = new DateTime($ual['date_add']);
//            $date_add_formatted_date = $date_addD->format('M, d Y');
//            $date_add_formatted_time = $date_addD->format('h:i A');
//
//        $from_ldateD = new DateTime($ual['from_ldate']);
//            $from_ldate_formatted_date = $from_ldateD->format('M, d');
//
//        $to_ldateD = new DateTime($ual['to_ldate']);
//            $to_ldate_formatted_date = $to_ldateD->format('M, d');
//
//            $interval = $from_ldateD->diff($to_ldateD);
//            $noOfD =  $interval->format('%d');
//            $noOfD =  (int)$noOfD+1;
//            $date_str =  $noOfD>1?'days':'day';
//
//        $approved_status = $ual['approved'];
//        $approved_by_name= $ual['approved_by_name'];
//        $leave_user_name= $ual['leave_user_name'];
//        $reason= $ual['reason'];
//
//        $approved_string = $approved_status == 1 ? 'APPROVED' : ($approved_status == -1 ? 'REJECTED' : 'PENDING');
//        $approved_status_color = $approved_status == 1 ? 'col-green' : ($approved_status == -1 ? 'col-red' : 'col-orange');
//
//        if($approved_by_name != null){
//            $approved_by_name = $approved_by_name;
//            $approved_timeD = new DateTime($ual['approved_time']);
//            $approved_timeD_formatted_date = $approved_timeD->format('M, d Y');
//            $approved_timeD_formatted_time = $approved_timeD->format('h:i A');
//            $le_approved_name = $approved_by_name."<br>".$approved_timeD_formatted_date . " | " . $approved_timeD_formatted_time;
//        }else{
//            $approved_timeD_formatted_date = '';
//            $approved_timeD_formatted_time = '';
//            $le_approved_name = 'NO-ONE';
//        }
//
//        $data[$i]['formatted_initiate']=$date_add_formatted_date . " | " . $date_add_formatted_time;
////        $data[$i]['formatted_approved']=$approved_timeD_formatted_date . " | " . $approved_timeD_formatted_time;
//        $data[$i]['formatted_dateTime']=$from_ldate_formatted_date . " - " . $to_ldate_formatted_date." ( ".$noOfD." ".$date_str." )" ;
//        $data[$i]['le_user']=$leave_user_name;
//        $data[$i]['le_reason']=$reason;
//        $data[$i]['le_status']=$approved_string;
//        $data[$i]['le_approved_name']=$le_approved_name;
//
//        $data[$i]['dt_row_color_class']=$approved_status_color ;
//        $data[$i]['leave_id']=$ual['id'] ;
//
//    } // end of for loop
//
//    $results = array(
//        "TotalRecords" => count($allUsers_all_leaves),
//        "data"=>$data
//    );
//    echo json_encode($results);
//    exit;
//}