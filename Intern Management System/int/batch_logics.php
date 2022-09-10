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

if(isset($_REQUEST['dtShowAllTeamsOfUser']) && $_REQUEST['dtShowAllTeamsOfUser']=='team_lists') {

    $teams = getAllHistoryTeamsOFUser($userId);
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

// datatable show all projects
if(isset($_REQUEST['dtShowAllProjectsOfUser']) && $_REQUEST['dtShowAllProjectsOfUser']=='projects_list') {

    $projects = getAllHistoryProjectOfUser($userId);
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

// datatable show all batches
if(isset($_REQUEST['dtShowAllBatchesOfUser']) && $_REQUEST['dtShowAllBatchesOfUser']=='batch_list') {

    $batches = getAllHistoryBatchesOfUser($userId);
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