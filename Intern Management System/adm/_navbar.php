<?php
/**
 * Created by PhpStorm.
 * User: Vijay Purohit
 * Date: 5/22/2019
 * Time: 11:09 AM
 * Project: ims_vj
 */
//
//// if session is not set then redirect them to login page
//require_once('_sessions.php');
//require_once(INCLUDE_PATH . "/logic/common_functions.php");
//
//$user_s = $_SESSION['user'];
//$user = getUserRoleProfile($user_s['id']);
////$userAndRole = getRoleOfUser($user['uid']);
////$userPermissions = getRolePermissionsOfUser($user['role_id']);
////Date Time
//$today_date_string = new DateTime();
//$today_date_time =  $today_date_string->format('D M, d Y h:i A');
//$today_date_normal = $today_date_string->format('Y-m-d');
//$today_date_year = $today_date_string->format('Y');
//$today_date_mon_n = $today_date_string->format('m');
//
//if($user['profile_picture']==NULL){
//    $profPicName = 'user.png';
//    $lastUpdateNumDaysMonths='Not Uploaded.';
//    $format_lastUpdateTime='-0';
//}
//else{
//    $profPicName = $user['profile_picture'];
//    $profPicName_array = explode("-", $profPicName);
//    $format_lastUpdateTime = date('Y-m-d H:i:s', $profPicName_array['0']);
//    $format_lastUpdateDate = date('Y-m-d', $profPicName_array['0']);
//
//    $d1= new DateTime($format_lastUpdateDate);
//    $d2 = new DateTime('now');
//        $interval = $d1->diff($d2);
//    $lastUpdateNumDaysMonths =  $interval->format('%m months, %R%d days');
//}

?>
<body class="theme-deep-purple">
<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="preloader">
            <div class="spinner-layer pl-red">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
        </div>
        <p>Please wait...</p>
    </div>
</div>
<!-- #END# Page Loader -->

<!-- Overlay For Sidebars -->
<div class="overlay"></div>
<!-- #END# Overlay For Sidebars -->

<!-- Search Bar -->
<!--<div class="search-bar">-->
<!--    <div class="search-icon">-->
<!--        <i class="material-icons">search</i>-->
<!--    </div>-->
<!--    <input type="text" placeholder="START TYPING...">-->
<!--    <div class="close-search">-->
<!--        <i class="material-icons">close</i>-->
<!--    </div>-->
<!--</div>-->
<!-- #END# Search Bar -->

<nav class="navbar">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
            <a href="javascript:void(0);" class="bars"></a>
            <a class="navbar-brand com bo" href="index.php" data-toggle="tooltip" data-placement="right" title="Intern Management System" ><?php echo APP_NAV_NAME?></a>
        </div>

        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <!-- Call Search -->

<!--                <li><a href="javascript:void(0);" class="js-search" data-close="true"><i class="material-icons">search</i></a></li>-->
                <!-- #END# Call Search -->
                <!-- Notifications -->
                <?php
                $requested_Task = getAllRequestedTasks();
                ?>
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            <i class="material-icons" data-toggle="tooltip" data-placement="left" title="Tasks Notifications">notifications</i>
                            <span class="label-count"><?php
                               echo  count($requested_Task);
                                ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">TASKS NOTIFY</li>
                            <li class="body">
                                <ul class="menu">
                                    <?php
                                    foreach ( $requested_Task as $rt) {

                                        $datetime1 = new DateTime($rt['requested_at']);//start time
                                        $datetime2 = new DateTime();//end time
                                        $interval = $datetime1->diff($datetime2);
                                        $h_d = $interval->format('%d days %H hours ago');

                                        $url_page ="task_show.php?tkid=$rt[tkid]";
                                    ?>

                                    <li>
                                        <a href="<?php echo $url_page?>">
                                            <div class="icon-circle bg-light-green">
                                                <i class="material-icons">cached</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4><b><?php echo $rt['intern_name'];?></b> requested task </h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> <?php echo $h_d;?>
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                    <?php
                                    }
                                    ?>
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="<?php echo $adm_pages_link ?>tasks_list_history.php">View All Tasks</a>
                            </li>
                        </ul>
                    </li>
                <!-- #END# Notifications -->
                <!-- Tasks -->
                <?php
                $year_check=$today_date_year;
                $requested_Leave = getAllUsersLeavesPendingRequest($year_check);
                ?>
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            <i class="material-icons" data-toggle="tooltip" data-placement="left" title="Leave Notification" >flag</i>
                            <span class="label-count"><?php
                                echo  count($requested_Leave);
                                ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">LEAVES PENDING</li>
                            <li class="body">
                                <ul class="menu tasks">
                                    <?php
                                    foreach ( $requested_Leave as $rl) {

                                        $datetime1 = new DateTime($rl['date_add']);//start time
                                        $datetime2 = new DateTime();//end time
                                        $interval = $datetime1->diff($datetime2);
                                        $h_d = $interval->format('%d days %H hours ago');

//                                        $url = urlencode(serialize($rl));
                                        $url_page = $adm_pages_link ."intern_leave_accept.php";
                                        ?>

                                        <li>
                                            <a href="<?php echo $url_page?>">
                                                <div class="icon-circle bg-light-green">
                                                    <i class="material-icons">add_shopping_cart</i>
                                                </div>
                                                <div class="menu-info">
                                                    <h4><b><?php echo $rl['leave_user_name'];?></b> requested Leave </h4>
                                                    <p>
                                                        <i class="material-icons">access_time</i> <?php echo $h_d;?>
                                                    </p>
                                                </div>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                    ?>
<!--                                    <li>-->
<!--                                        <a href="javascript:void(0);">-->
<!--                                            <h4>-->
<!--                                                Answer GitHub questions-->
<!--                                                <small>92%</small>-->
<!--                                            </h4>-->
<!--                                            <div class="progress">-->
<!--                                                <div class="progress-bar bg-purple" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 92%">-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </a>-->
<!--                                    </li>-->
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="<?php echo $adm_pages_link ?>leave_history.php">View All Leaves</a>
                            </li>
                        </ul>
                    </li>
                <!-- #END# Tasks -->
<!--                <li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="material-icons">more_vert</i></a></li>-->
            </ul>
        </div>
    </div>
</nav>
