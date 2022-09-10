<?php
/**
 * Created by PhpStorm.
 * User: Vijay Purohit
 * Date: 10-Jun-19
 * Time: 2:54 PM
 * Project: ims_vj
 */

$from_url_path='intern';
$subTitle = 'INTERN '.base64_decode('WyB2aWpheWNoaXR0aSBda');

require_once($asset_path_link.'config.php');
// if session is not set then redirect them to login page
require_once('_sessions.php');
require_once(INCLUDE_PATH . "/logic/common_functions.php");

$user_s = $_SESSION['user'];
$user = getUserRoleProfile($user_s['id']);
//$userAndRole = getRoleOfUser($user['uid']);
//$userPermissions = getRolePermissionsOfUser($user['role_id']);
//Date Time
$today_date_string = new DateTime();
$today_date_time =  $today_date_string->format('D M, d Y h:i A');
$today_date_normal = $today_date_string->format('Y-m-d');
$today_date_year = $today_date_string->format('Y');
$today_date_mon_n = $today_date_string->format('m');

if($user['profile_picture']==NULL){
$profPicName = '_user.png';
$lastUpdateNumDaysMonths='Not Uploaded.';
$format_lastUpdateTime='-0';
}
else{
$profPicName = $user['profile_picture'];
$profPicName_array = explode("-", $profPicName);
$format_lastUpdateTime = date('Y-m-d H:i:s', $profPicName_array['0']);
//$format_lastUpdateDate = date('Y-m-d', $profPicName_array['0']);

$d1= new DateTime($format_lastUpdateTime);
$d2 = new DateTime();
$interval = $d1->diff($d2);
$lastUpdateNumDaysMonths =  $interval->format('%m months, %R%d days %H hours ago');
}
if($user['user_sign']==NULL){
    $userSignName = '_sign.png';
    $lastUpdateNumDaysMonthsUserSignName='Not Uploaded.';
    $format_lastUpdateTimeUserSignName ='-0';
}
else{
    $userSignName = $user['user_sign'];
    $UserSignName_array = explode("-", $userSignName); // timestamp
    $format_lastUpdateTimeUserSignName = date('Y-m-d H:i:s', $UserSignName_array['0']);

    $d1= new DateTime($format_lastUpdateTimeUserSignName);
    $d2 = new DateTime();
    $interval = $d1->diff($d2);
    $lastUpdateNumDaysMonthsUserSignName = $interval->format('%m months, %R%d days %H hours ago');

}
?>

<!DOCTYPE html>
<html lang="en">
<!-- ---------------------------------------------------HTML HEADER ----------------------------------------------------- -->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title id="app_title"><?php echo APP_TITLE." - ".$subTitle ?></title>
    <?php  require_once (INCLUDE_PATH .'/layouts/_header.php'); ?>
    <!-- Custom Css -->
    <link href="<?php echo $asset_path_link; ?>assets/bsb/css/style.css" rel="stylesheet">
</head>
<!-- ---------------------------------------------------END HTML HEADER -------------------------------------------------- -->
<!-- -------------------------------------------------- HTML BODY -------------------------------------------------------- -->

<!-- Top Bar -->
<?php  require_once (INT_PATH .'/_navbar.php'); ?>
<!-- #Top Bar -->
<section>
    <!-- Left Sidebar -->
    <?php  require_once (INT_PATH .'/_sidebar.php'); ?>
    <!-- #END# Left Sidebar -->

    <!-- Right Sidebar -->
    <!--    --><?php // require_once (INT_PATH .'/_rSidebar.php'); ?>
    <!-- #END# Right Sidebar -->
</section>
