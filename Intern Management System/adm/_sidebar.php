<?php
/**
 * Created by PhpStorm.
 * User: Vijay Purohit
 * Date: 5/21/2019
 * Time: 12:53 PM
 * Project: ims_vj
 */

$user_folder_name = 'users'.'/';
$batch_folder_name = ''.'';
?>
<aside id="leftsidebar" class="sidebar">
    <!-- User Info -->
    <div class="user-info">
        <div class="image">
            <?php global $profPicName;?>
            <img src="<?php echo UPLOAD_URL.$upload_profile_fol_name.$profPicName; ?>" width="48" height="48" alt="User" />
        </div>
        <div  class="pull-right">
            <div id="datetime" style="color: #ffffff;"></div>
            <div style="position: relative; text-align: right; padding-top: 3px"><span class="badge bg-grey"><?php echo ucwords($user['role']); ?></span></div>
        </div>

        <div class="info-container">
            <div class="bo name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span><?php echo ucwords($user['full_name']); ?> </span></div>
            <div class="email"><?php echo strtolower($user['email']); ?></div>
            <div class="btn-group user-helper-dropdown">
                <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                <ul class="dropdown-menu pull-right">
                    <li><a href="<?php echo $adm_pages_link ?>my_profile.php"><i class="material-icons">person</i>Profile Settings</a></li>
                    <li role="separator" class="divider"></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="<?php echo $asset_path_link ?>db/"><i class="material-icons">list</i>DB BACKUP</a></li>
                    <li><a href="<?php echo $adm_pages_link ?>_logout.php"><i class="material-icons">input</i>Sign Out</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- #User Info -->
    <!-- Menu -->
    <div class="menu">
        <ul class="list">
            <li class="header" style="text-align: center">ACTIONS</li>
            <li class="active">
                <a href="<?php echo $adm_pages_link ?>index.php">
                    <i class="material-icons">home</i>
                    <span>Home</span>
                </a>
            </li>
<!--PROFILE-->
<!--            <li >-->
<!--                <a href="--><?php //echo $adm_pages_link.$user_folder_name ?><!--user_profile_view.php">-->
<!--                    <i class="material-icons">face</i>-->
<!--                    <span data-toggle="tooltip" data-placement="right" title="your detailed profile">My Profile</span>-->
<!--                </a>-->
<!--            </li>-->
<!--USERs-->
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">people</i>
                    <span>USERs</span>
                </a>
                <ul class="ml-menu">
                    <li>
                        <a href="<?php echo $adm_pages_link.$user_folder_name ?>user_registration.php">
                            <span data-toggle="tooltip" data-placement="right" title="create a new user">Registration</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $adm_pages_link ?>batch_interns_list.php">
                            <span  data-toggle="tooltip" data-placement="right" title="list of interns of ongoing batches" >Interns</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $adm_pages_link.$user_folder_name ?>users_list.php">
                            <span  data-toggle="tooltip" data-placement="right" title="list of all users registered" >List</span>
                        </a>
                    </li>
                </ul>
            </li>
<!--Batch-->
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">streetview</i>
                    <span>BATCH</span>
                </a>
                <ul class="ml-menu">
                    <li>
                        <a href="<?php echo $adm_pages_link.$batch_folder_name ?>batch_create.php">
                            <span  data-toggle="tooltip" data-placement="right" title="create a new batch" >Create</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $adm_pages_link.$batch_folder_name ?>batch_add_interns.php">
                            <span data-toggle="tooltip" data-placement="right" title="add or transfer new interns">Admit Interns</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $adm_pages_link.$batch_folder_name ?>batch_ongoing_batches.php">
                            <span data-toggle="tooltip" data-placement="right" title="list of current batches">Ongoing Batches</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $adm_pages_link.$batch_folder_name ?>batches_list_history.php">
                            <span data-toggle="tooltip" data-placement="right" title="list of all the batches">List</span>
                        </a>
                    </li>
                </ul>
            </li>
<!--Team-->
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">rowing</i>
                    <span>TEAM</span>
                </a>
                <ul class="ml-menu">
                    <li>
                        <a href="<?php echo $adm_pages_link ?>batch_add_teams.php">
                            <span data-toggle="tooltip" data-placement="right" title="add a new teams">Create</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $adm_pages_link ?>team_ongoing.php">
                            <span data-toggle="tooltip" data-placement="right" title="list of current teams">Current Teams</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $adm_pages_link ?>team_list_history.php">
                            <span data-toggle="tooltip" data-placement="right" title="list of all the teams">List</span>
                        </a>
                    </li>
                </ul>
            </li>
<!--Project-->
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">android</i>
                    <span >PROJECT</span>
                </a>
                <ul class="ml-menu">
                    <li>
                        <a href="<?php echo $adm_pages_link ?>batch_add_teams_project.php">
                            <span data-toggle="tooltip" data-placement="right" title="add a new project and assign to a team">Assign</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $adm_pages_link ?>project_ongoing.php">
                            <span data-toggle="tooltip" data-placement="right" title="list of current projects">Current Projects</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $adm_pages_link ?>projects_list_history.php">
                            <span data-toggle="tooltip" data-placement="right" title="list of all the projects">List</span>
                        </a>
                    </li>
                </ul>
            </li>
<!--Tasks-->
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">add_circle</i>
                    <span>Task</span>
                </a>
                <ul class="ml-menu">
                    <li>
                        <a href="<?php echo $adm_pages_link ?>tasks_create.php">
                            <span  data-toggle="tooltip" data-placement="right" title="create a new task" >Create</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $adm_pages_link ?>tasks_ongoing.php">
                            <span  data-toggle="tooltip" data-placement="right" title="view all the pending tasks" >Pending</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $adm_pages_link ?>tasks_list_history.php">
                            <span  data-toggle="tooltip" data-placement="right" title="view all the tasks" >List</span>
                        </a>
                    </li>
                </ul>
            </li>
<!--Attendance-->
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">assignment_turned_in</i>
                    <span>ATTENDANCE</span>
                </a>
                <ul class="ml-menu">
                    <li>
                        <a href="<?php echo $adm_pages_link.$batch_folder_name ?>batch_attendance.php">
                            <span  data-toggle="tooltip" data-placement="right" title="mark interns attendance" >Submit</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $adm_pages_link.$batch_folder_name ?>batch_attendance_report.php">
                            <span data-toggle="tooltip" data-placement="right" title="show attendance report of current batch">Current Report</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $adm_pages_link.$batch_folder_name ?>batch_attendance_report_past.php">
                            <span data-toggle="tooltip" data-placement="right" title="show attendance report of all the batches">Past Report</span>
                        </a>
                    </li>
                </ul>
            </li>
<!--Leave-->
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">settings_ethernet</i>
                    <span>Leave</span>
                </a>
                <ul class="ml-menu">
                    <li>
                        <a href="<?php echo $adm_pages_link ?>intern_leave_accept.php">
                            <span  data-toggle="tooltip" data-placement="right" title="manage leave" >Manage</span>
                        </a>
                    </li>
<!--                    <li>-->
<!--                        <a href="--><?php //echo $adm_pages_link.$batch_folder_name ?><!--intern_leaves.php">-->
<!--                            <span data-toggle="tooltip" data-placement="right" title="initiate leave">Initiate</span>-->
<!--                        </a>-->
<!--                    </li>-->
                    <li>
                        <a href="<?php echo $adm_pages_link ?>leave_history.php">
                            <span data-toggle="tooltip" data-placement="right" title="all the leaves details">History</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <!-- #Menu -->
    <!-- Footer -->
    <div class="legal">
        <div class="copyright">
            &copy; <?php echo APP_CopyRightYEAR ?> <a data-toggle="tooltip" data-placement="right" title="<?php echo base64_decode("VmlqYXkgUHVyb2hpdCBbdmlqYXkucHU5QGdtYWlsLmNvbV0=") ?>" href="mailto:<?php echo base64_decode("dmlqYXkucHU5QGdtYWlsLmNvbQ==") ?>"><?php echo base64_decode("VlA=") ?></a>.
        </div>
        <div class="version">
            <b>Version: </b> <?php echo APP_VS ?>
        </div>
    </div>
    <!-- #Footer -->
</aside>
