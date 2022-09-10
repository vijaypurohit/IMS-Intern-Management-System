<?php
/**
 * Created by PhpStorm.
 * User: Vijay Purohit
 * Date: 5/22/2019
 * Time: 11:28 AM
 * Project: ims_vj
 */

$asset_path_link='../';
$adm_pages_link='';
$jqueryValidate=1;
?>
<?php  require_once($asset_path_link.'config.php'); ?>
<?php  require_once (ADM_PATH .'/_.php'); ?>
<?php // require_once('my_profile_logic.php'); ?>
<?php  require_once(INCLUDE_PATH . "/logic/my_profile_logic.php"); ?>


<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2 class="com bo"
                style="text-align: center; font-size: 20px; letter-spacing: 2px; padding-bottom: 5px;">
                MY PROFILE
            </h2>
        </div>
        <div class="row clearfix">

            <div class="col-xs-12 col-sm-3">
                <div class="card profile-card">
                    <div class="profile-header">&nbsp;</div>
                    <div class="profile-body">
                        <div class="image-area">
                            <?php global $profPicName;?>
                            <img src="<?php echo UPLOAD_URL.$upload_profile_fol_name.$profPicName; ?>" style="height: 128px; width:128px; border-radius: 50%;" alt="<?php echo $user['username']; ?>" />
                        </div>
                        <div class="content-area">
                            <h3><?php echo ucwords($user['full_name']); ?></h3>
                            <p><?php echo APP_USER_DESIG ?></p>
                            <p><?php echo ucwords($user['role']); ?></p>
                        </div>
                        <?php global $userSignName;?>
                        <div class="profile-footer" style="vertical-align:middle;background-position: right top; align-content: center">
                            <img class="image-area" style="height: 80%; width:80%; padding-top: 64px;" src="<?php echo UPLOAD_URL.$upload_profile_fol_name.$userSignName; ?>"  alt="<?php echo $user['username']."-sign"; ?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-9">
                <?php  include(INCLUDE_PATH . '/layouts/_messages.php'); ?>
                <div class="card">
                    <div class="body">
                        <div>
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" ><a href="#profile_settings" aria-controls="settings" role="tab" data-toggle="tab">Profile Settings</a></li>
                                <li role="presentation" ><a href="#change_password_settings" aria-controls="settings" role="tab" data-toggle="tab">Change Password</a></li>
                                <li role="presentation" ><a href="#change_profile_picture" aria-controls="settings" role="tab" data-toggle="tab">Profile Picture</a></li>
                                <li role="presentation" ><a href="#change_user_signature" aria-controls="settings" role="tab" data-toggle="tab">User Signature</a></li>
                            </ul>

                            <div class="tab-content">

                                <!--tab profile settings-->
                                <div role="tabpanel" class="tab-pane fade in" id="profile_settings">
                                    <div class="row clearfix">
<!--                                        <div class="col-md-12">-->
                                            <div class="col-md-6">
                                                <div class="col-md-4">
                                                    <label class="to">UserName: </label>
                                                </div>
                                                <div class="col-md-8">
                                                    <label class="tp"><?php echo $user['username']; ?></label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="col-md-4">
                                                    <label  class="to">Email: </label>
                                                </div>
                                                <div class="col-md-8">
                                                    <label class="tp"><?php echo strtolower($user['email']); ?></label>
                                                </div>
                                            </div>
<!--                                        </div>-->
                                    </div>
                                </div><!--END tab profile settings-->
                                <!--tab change password-->
                                <div role="tabpanel" class="tab-pane fade in" id="change_password_settings">
                            <form id="update_pass_form" action="my_profile.php" method="post" class="form-horizontal">
                                <div class="form-group">
                                    <label for="OldPassword" class="col-md-3 control-label">Old Password</label>
                                    <div class="col-sm-9" id="e">
                                        <div class="form-line">
                                            <input type="password" class="form-control" id="OldPassword" name="OldPassword" placeholder="Old Password" required>
                                        </div>
                                    </div>
                                    <span class="col-sm-9"></span>
                                </div>
                                <div class="form-group">
                                    <label for="NewPassword" class="col-sm-3 control-label">New Password</label>
                                    <div class="col-sm-9" id="e">
                                        <div class="form-line" >
                                            <input type="password" class="form-control" id="NewPassword" name="NewPassword" placeholder="New Password" required>
                                        </div>
                                    </div>
                                    <span class="col-sm-9"></span>
                                </div>
                                <div class="form-group">
                                    <label for="NewPasswordConfirm" class="col-sm-3 control-label">New Password (Confirm)</label>
                                    <div class="col-sm-9" id="e">
                                        <div class="form-line">
                                            <input type="password" class="form-control" id="NewPasswordConfirm" name="NewPasswordConfirm" placeholder="New Password (Confirm)" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-9">
                                        <button type="submit" name="update_pass" class="btn btn-danger waves-effect">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div><!--END tab change password-->
                                <!--tab change picture-->
                                <div role="tabpanel" class="tab-pane fade in" id="change_profile_picture">
                            <form id="update_picture_form" action="my_profile.php" method="post" class="form-horizontal" enctype="multipart/form-data">
<!--                                <div class="form-group">-->
                                <div class="form-group" style="text-align: center; padding-left: 25px">
                                    <?php global $profPicName; global $lastUpdateNumDaysMonths; global $format_lastUpdateTime;?>
                                    <div>
                                        <img class="image-area" src="<?php echo UPLOAD_URL.$upload_profile_fol_name.$profPicName; ?>" id="profile_img" style="height: 150px; width:150px; border-radius: 50%;" alt="<?php echo $user['username']."-profile-img"; ?>" data-toggle="tooltip" data-placement="bottom" title="1. Click on this Picture to Select a New One">
                                    </div>
                                    <!-- hidden file input to trigger with JQuery  -->
                                    <input type="file" name="profile_picture" id="profile_input" value="" accept="image/*"  style="display: none;">
<p class="input-group" id="uppp"></p>

                                    <div class="help-info" style="padding-bottom: 5px; font-weight: bold">Last Update Time: <?php echo $format_lastUpdateTime." (".$lastUpdateNumDaysMonths.") ";?></div>
<!--                                    <div class="form-group align-center" style="padding-top: 20px; ">-->
<!--                                        <div class="col-xs-2 col-sm-3">-->
                                            <button type="submit" name="update_picture" class="btn btn-danger btn-block waves-effect" data-toggle="tooltip" data-placement="bottom" title="2. To Upload To Server">Update</button>
<!--                                        </div>-->
<!--                                    </div>-->
                                </div>
<!--                                </div>-->
                            </form>
                        </div><!--END tab change picture-->
                                <!--tab change user sign-->
                                <div role="tabpanel" class="tab-pane fade in" id="change_user_signature">
                                    <form id="update_user_sign" action="my_profile.php" method="post" class="form-horizontal" enctype="multipart/form-data">
                                        <!--                                <div class="form-group">-->
                                        <div class="form-group" style="text-align: center; padding-left: 25px">
                                            <?php global $userSignName; global $lastUpdateNumDaysMonthsUserSignName; global $format_lastUpdateTimeUserSignName;?>
                                            <img class="image-area" src="<?php echo UPLOAD_URL.$upload_profile_fol_name.$userSignName; ?>" id="user-sign-img" style="height: 80%; width:80%;" alt="<?php echo $user['username']."-sign"; ?>" data-toggle="tooltip" data-placement="bottom" title="1. Click on this Picture to Select a New One">
                                            <!-- hidden file input to trigger with JQuery  -->
                                            <input type="file" name="user_sign_input" id="user_sign_input" value="" accept="image/*"  style="display: none;">
                                            <p class="input-group" id="uppp-sign"></p>

                                            <div class="help-info" style="padding-bottom: 5px; font-weight: bold">Last Update Time: <?php echo $format_lastUpdateTimeUserSignName." (".$lastUpdateNumDaysMonthsUserSignName.") ";?></div>
                                            <!--                                    <div class="form-group align-center" style="padding-top: 20px; ">-->
                                            <!--                                        <div class="col-xs-2 col-sm-3">-->
                                            <button type="submit" name="update_sign_submit" class="btn btn-danger btn-block waves-effect" data-toggle="tooltip" data-placement="bottom" title="2. To Upload To Server">Update</button>
                                            <!--                                        </div>-->
                                            <!--                                    </div>-->
                                        </div>
                                        <!--                                </div>-->
                                    </form>
                                </div><!--END tab change user sign-->
                    </div>
                </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ----------------------------------------- END HTML BODY ------------------------------------------------------------ -->

<!-- ----------------------------------------- HTML FOOTER --------------------------------------------------------------- -->
<?php require_once (INCLUDE_PATH .'/layouts/_footer.php'); ?>
<!-- Custom Js -->
<!-- Demo Js for skin color etc-->
<!--<script src="--><?php //echo $asset_path_link ?><!--assets/bsb/js/demo.js"></script>-->

<script  src="<?php echo $asset_path_link ?>assets/bsb/js/pages/examples/profile.js"></script>

<!-- ------------------------------------------END HTML FOOTER --------------------------------------------------------------- -->
</html>