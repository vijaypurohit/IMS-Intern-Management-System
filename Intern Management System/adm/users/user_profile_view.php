<?php
/**
 * Created by PhpStorm.
 * User: Vijay Purohit
 * Date: 5/29/2019
 * Time: 5:33 PM
 * Project: ims_vj
 */

$asset_path_link = '../../';
$adm_pages_link = '../';

$jqueryDataTable=1;
?>
<?php  require_once($asset_path_link.'config.php'); ?>
<?php  require_once (ADM_PATH .'/_.php'); ?>
<?php  require_once('user_logic.php'); ?>

<?php
    $uid = $_SESSION['user']['id'];
    if (isset($_REQUEST['uid'])) {
        $uid = $_REQUEST['uid'];        // user id to view their profile
    }
    if (isset($_REQUEST['used_id_to_disable'])) {
        $uid = $_REQUEST['used_id_to_disable'];        // user id to view their profile after disable
    }
$part_user = getUserRoleProfile($uid);
?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2 class="com bo"
                style="text-align: center; font-size: 20px; letter-spacing: 2px; padding-bottom: 3px;">
                PROFILE - <?php echo $part_user['full_name'] ?>
            </h2>
        </div>
        <div class="row clearfix">

            <div class="col-xs-12 col-sm-12">

<?php include(INCLUDE_PATH . '/layouts/_messages.php'); ?>
                <div class="row clearfix">
                    <!--PROFILE-->
                    <div class="col-xs-12 col-sm-3">
                        <div class="card profile-card">
                            <div class="profile-header">&nbsp;</div>
                            <div class="profile-body">
                                <div class="image-area">
                                    <?php
                                    if ($part_user['profile_picture'] == NULL) {
                                        $profPicName_o = '_user.png';
                                        $lastUpdateNumDaysMonths = 'Not Uploaded.';
                                        $format_lastUpdateTime = '-0';
                                    } else {
                                        $profPicName_o = $part_user['profile_picture'];
                                        $profPicName_array = explode("-", $profPicName_o);
                                        $format_lastUpdateTime = date('Y-m-d H:i:s', $profPicName_array['0']);
                                        $format_lastUpdateDate = date('Y-m-d', $profPicName_array['0']);

                                        $d1 = new DateTime($format_lastUpdateDate);
                                        $d2 = new DateTime('now');
                                        $interval = $d1->diff($d2);
                                        $lastUpdateNumDaysMonths = $interval->format('%m months, %R%a days');
                                    }
                                    if($part_user['user_sign']==NULL){
                                        $userSignName = '_sign.png';
                                        $lastUpdateNumDaysMonthsUserSignName='Not Uploaded.';
                                        $format_lastUpdateTimeUserSignName ='-0';
                                    }
                                    else{
                                        $userSignName = $part_user['user_sign'];
                                        $UserSignName_array = explode("-", $userSignName); // timestamp
                                        $format_lastUpdateTimeUserSignName = date('Y-m-d H:i:s', $UserSignName_array['0']);

                                        $d1= new DateTime($format_lastUpdateTimeUserSignName);
                                        $d2 = new DateTime();
                                        $interval = $d1->diff($d2);
                                        $lastUpdateNumDaysMonthsUserSignName = $interval->format('%m months, %R%d days %H hours ago');

                                    }
                                    ?>
                                    <img src="<?php echo UPLOAD_URL . $upload_profile_fol_name . $profPicName_o; ?>"
                                         style="height: 128px; width:128px; border-radius: 50%;"
                                         alt="<?php echo $part_user['username']; ?>"/>
                                </div>
                                <div class="content-area">
                                    <h3><?php echo ucwords($part_user['full_name']); ?></h3>
                                    <p><?php echo APP_USER_DESIG ?></p>
                                    <p><?php echo ucwords($part_user['role']); ?></p>
                                </div>
                            </div>
                            <div class="profile-footer">
<!--                                <ul>-->
<!---->
<!--                                    <li>-->
<!--                                        <span>Sign</span>-->
<!--                                        <span>-img-</span>-->
<!--                                    </li>-->
<!--                                </ul>-->
                                <div class="help-block" style="vertical-align:middle;background-position: right top; align-content: center">
                                    <img class="image-area" style="height: 80%; width:80%; " src="<?php echo UPLOAD_URL.$upload_profile_fol_name.$userSignName; ?>"  alt="<?php echo $user['username']."-sign"; ?>">
                                </div>
                                <?php

                                if ($part_user['uid'] != $_SESSION['user']['id']) {
                                    if ($part_user['c_status'] == 1) {
                                        $c_status_color = 'btn-danger';
                                        $string_s = 'DISABLE';
                                        $value_s = -1;
                                    } else {
                                        $c_status_color = 'btn-info';
                                        $string_s = 'ENABLE';
                                        $value_s = 1;
                                    }
                                    ?>
                                    <form id="disable_user_form" action="user_profile_view.php" method="post"
                                          class="form-horizontal">
                                        <input type="hidden" name="used_id_to_disable" value="<?php echo $uid ?>">
                                        <input type="hidden" name="used_name_to_disable" value="<?php echo $part_user['full_name'] ?>">
                                        <input type="hidden" name="value_s" value="<?php echo $value_s ?>">
                                        <input type="hidden" name="by_id" value="<?php echo $_SESSION['user']['id'] ?>">
                                        <input type="hidden" name="value_string" value="<?php echo $string_s ?>">
                                        <button type="submit" name="disable_user" value="user_profile_view"
                                            class="btn <?php echo $c_status_color ?> btn-lg waves-effect btn-block"><?php echo $string_s ?></button>
                                    </form>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <!--END PROFILE-->
                    <!--TECH-->

                    <!--END TECH-->
<!--                    profile detail-->

                    <div class="col-xs-8 col-sm-8">
                        <div class="card">
                            <div class="body" style="padding-bottom: 0px !important;">
                                <div>
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active"><a href="#credential" aria-controls="settings" role="tab"
                                                                                  data-toggle="tab"><i class="material-icons">fingerprint</i>
                                            </a></li>
                                        <!--                                <li role="presentation" ><a href="#profile" aria-controls="settings"-->
                                        <!--                                                                          role="tab" data-toggle="tab"><i-->
                                        <!--                                                class="material-icons">face</i></a></li>-->
                                    </ul>
                                    <div class="tab-content">

                                        <!--tab credential -->
                                        <div role="tabpanel" class="tab-pane animated flipInX active" id="credential">
                                            <div class="row clearfix" style="padding-top: 10px;">
                                                <div class="col-xs-12 col-sm-6 col-md-6">
                                                    <div class="col-xs-5 col-sm-4 col-md-4 ">
                                                        <label class="to">UserName: </label>
                                                    </div>
                                                    <div class="col-xs-7 col-sm-8 col-md-8 ">
                                                        <label class="tp"><?php echo $part_user['username']; ?></label>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-6 ">
                                                    <div class="col-xs-5 col-sm-4 col-md-4 ">
                                                        <label class="to">Email: </label>
                                                    </div>
                                                    <div class="col-xs-7 col-sm-8 col-md-8 ">
                                                        <label class="tp"><?php echo strtolower($part_user['email']); ?></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <form id="reset_user_form" action="user_profile_view.php" method="post"
                                                  class="form-horizontal">
                                                <input type="hidden" name="user_id_to_reset" value="<?php echo $uid ?>">
                                                <input type="hidden" name="user_name_to_reset" value="<?php echo $part_user['username'] ?>">
                                                <input type="hidden" name="by_id" value="<?php echo $_SESSION['user']['id'] ?>">
                                                <button type="submit" name="reset_user" value="user_profile_view_reset_user"
                                                        class="btn btn-grey btn-sm waves-effect btn-block">RESET PASSWORD</button>
                                            </form>


                                        </div><!--END tab credential -->
                                        <!--tab profile -->
                                        <!--                                <div role="tabpanel" class="tab-pane fade in active" id="profile">-->
                                        <!--                                    <div class="row clearfix" style="padding-top: 10px;">-->
                                        <!-- 1 row begins-->
                                        <!--                                        <div class="row clearfix">-->
                                        <!--                                            <div class="col-xs-12 col-sm-6 col-md-6">-->
                                        <!--                                                <div class="col-xs-5 col-sm-5 col-md-4 ">-->
                                        <!--                                                    <label class="to">Name: </label>-->
                                        <!--                                                </div>-->
                                        <!--                                                <div class="col-xs-7 col-sm-7 col-md-8 ">-->
                                        <!--                                                    <label class="tp">--><?php //echo ucwords($part_user['full_name']); ?><!--</label>-->
                                        <!--                                                </div>-->
                                        <!--                                            </div>-->
                                        <!--                                            <div class="col-xs-12 col-sm-6 col-md-6 ">-->
                                        <!--                                                <div class="col-xs-5 col-sm-5 col-md-4 ">-->
                                        <!--                                                    <label class="to">Email: </label>-->
                                        <!--                                                </div>-->
                                        <!--                                                <div class="col-xs-7 col-sm-7 col-md-8 ">-->
                                        <!--                                                    <label class="tp">--><?php //echo strtolower($part_user['email']); ?><!--</label>-->
                                        <!--                                                </div>-->
                                        <!--                                            </div>-->
                                        <!--                                        </div>-->
                                        <!-- 1 row ENDS-->
                                        <!-- 2 row begins-->
                                        <!--                                        <div class="row clearfix">-->
                                        <!--                                            <div class="col-xs-12 col-sm-6 col-md-6">-->
                                        <!--                                                <div class="col-xs-5 col-sm-5 col-md-4 ">-->
                                        <!--                                                    <label class="to">Father Name </label>-->
                                        <!--                                                </div>-->
                                        <!--                                                <div class="col-xs-7 col-sm-7 col-md-8 ">-->
                                        <!--                                                    <label class="tp">--><?php //echo ucwords($part_user['full_name']); ?><!--</label>-->
                                        <!--                                                </div>-->
                                        <!--                                            </div>-->
                                        <!--                                            <div class="col-xs-12 col-sm-6 col-md-6 ">-->
                                        <!--                                                <div class="col-xs-5 col-sm-5 col-md-4 ">-->
                                        <!--                                                    <label class="to">Mother Name </label>-->
                                        <!--                                                </div>-->
                                        <!--                                                <div class="col-xs-7 col-sm-7 col-md-8 ">-->
                                        <!--                                                    <label class="tp">--><?php //echo strtolower($part_user['email']); ?><!--</label>-->
                                        <!--                                                </div>-->
                                        <!--                                            </div>-->
                                        <!--                                        </div>-->
                                        <!-- 2 row ENDS-->
                                        <!-- 3 row begins-->
                                        <!--                                        <div class="row clearfix">-->
                                        <!--                                            <div class="col-xs-12 col-sm-6 col-md-6">-->
                                        <!--                                                <div class="col-xs-5 col-sm-5 col-md-4 ">-->
                                        <!--                                                    <label class="to">Date of Birth </label>-->
                                        <!--                                                </div>-->
                                        <!--                                                <div class="col-xs-7 col-sm-7 col-md-8 ">-->
                                        <!--                                                    <label class="tp">--><?php //echo ucwords($part_user['full_name']); ?><!--</label>-->
                                        <!--                                                </div>-->
                                        <!--                                            </div>-->
                                        <!--                                            <div class="col-xs-12 col-sm-6 col-md-6 ">-->
                                        <!--                                                <div class="col-xs-5 col-sm-5 col-md-4 ">-->
                                        <!--                                                    <label class="to">Batch </label>-->
                                        <!--                                                </div>-->
                                        <!--                                                <div class="col-xs-7 col-sm-7 col-md-8 ">-->
                                        <!--                                                    <label class="tp">--><?php //echo strtolower($part_user['email']); ?><!--</label>-->
                                        <!--                                                </div>-->
                                        <!--                                            </div>-->
                                        <!--                                        </div>-->
                                        <!-- 3 row ENDS-->
                                        <!-- 4 row begins-->
                                        <!--                                        <div class="row clearfix">-->
                                        <!--                                            <div class="col-xs-12 col-sm-6 col-md-6">-->
                                        <!--                                                <div class="col-xs-5 col-sm-5 col-md-4 ">-->
                                        <!--                                                    <label class="to">Student Mobile </label>-->
                                        <!--                                                </div>-->
                                        <!--                                                <div class="col-xs-7 col-sm-7 col-md-6 ">-->
                                        <!--                                                    <label class="tp">--><?php //echo ucwords($part_user['full_name']); ?><!--</label>-->
                                        <!--                                                </div>-->
                                        <!--                                            </div>-->
                                        <!--                                            <div class="col-xs-12 col-sm-6 col-md-6 ">-->
                                        <!--                                                <div class="col-xs-5 col-sm-5 col-md-4 ">-->
                                        <!--                                                    <label class="to">Parents Mobile </label>-->
                                        <!--                                                </div>-->
                                        <!--                                                <div class="col-xs-7 col-sm-7 col-md-6 ">-->
                                        <!--                                                    <label class="tp">--><?php //echo strtolower($part_user['email']); ?><!--</label>-->
                                        <!--                                                </div>-->
                                        <!--                                            </div>-->
                                        <!--                                        </div>-->
                                        <!-- 4 row ENDS-->
                                        <!-- 5 row begins-->
                                        <!--                                        <div class="row clearfix">-->
                                        <!--                                            <div class="col-xs-12 col-sm-6 col-md-6">-->
                                        <!--                                                <div class="col-xs-5 col-sm-5 col-md-4 ">-->
                                        <!--                                                    <label class="to">Category </label>-->
                                        <!--                                                </div>-->
                                        <!--                                                <div class="col-xs-7 col-sm-7 col-md-6 ">-->
                                        <!--                                                    <label class="tp">--><?php //echo ucwords($part_user['full_name']); ?><!--</label>-->
                                        <!--                                                </div>-->
                                        <!--                                            </div>-->
                                        <!--                                            <div class="col-xs-12 col-sm-6 col-md-6 ">-->
                                        <!--                                                <div class="col-xs-5 col-sm-5 col-md-4 ">-->
                                        <!--                                                    <label class="to">Gender </label>-->
                                        <!--                                                </div>-->
                                        <!--                                                <div class="col-xs-7 col-sm-7 col-md-6 ">-->
                                        <!--                                                    <label class="tp">--><?php //echo strtolower($part_user['email']); ?><!--</label>-->
                                        <!--                                                </div>-->
                                        <!--                                            </div>-->
                                        <!--                                        </div>-->
                                        <!-- 5 row ENDS-->
                                        <!-- 6 row begins-->
                                        <!--                                        <div class="row clearfix">-->
                                        <!--                                            <div class="col-xs-12 col-sm-6 col-md-6">-->
                                        <!--                                                <div class="col-xs-5 col-sm-5 col-md-4 ">-->
                                        <!--                                                    <label class="to">Blood Group </label>-->
                                        <!--                                                </div>-->
                                        <!--                                                <div class="col-xs-7 col-sm-7 col-md-6 ">-->
                                        <!--                                                    <label class="tp">--><?php //echo ucwords($part_user['full_name']); ?><!--</label>-->
                                        <!--                                                </div>-->
                                        <!--                                            </div>-->
                                        <!--                                            <div class="col-xs-12 col-sm-6 col-md-6 ">-->
                                        <!--                                                <div class="col-xs-5 col-sm-5 col-md-4 ">-->
                                        <!--                                                    <label class="to">Religion </label>-->
                                        <!--                                                </div>-->
                                        <!--                                                <div class="col-xs-7 col-sm-7 col-md-6 ">-->
                                        <!--                                                    <label class="tp">--><?php //echo strtolower($part_user['email']); ?><!--</label>-->
                                        <!--                                                </div>-->
                                        <!--                                            </div>-->
                                        <!--                                        </div>-->
                                        <!-- 6 row ENDS-->
                                        <!-- 6 row begins-->
                                        <!--                                        <div class="row clearfix">-->
                                        <!--                                            <div class="col-xs-12 col-sm-6 col-md-6">-->
                                        <!--                                                <div class="col-xs-5 col-sm-5 col-md-4 ">-->
                                        <!--                                                    <label class="to">Branch </label>-->
                                        <!--                                                </div>-->
                                        <!--                                                <div class="col-xs-7 col-sm-7 col-md-6 ">-->
                                        <!--                                                    <label class="tp">--><?php //echo ucwords($part_user['full_name']); ?><!--</label>-->
                                        <!--                                                </div>-->
                                        <!--                                            </div>-->
                                        <!--                                            <div class="col-xs-12 col-sm-6 col-md-6 ">-->
                                        <!--                                                <div class="col-xs-5 col-sm-5 col-md-4 ">-->
                                        <!--                                                    <label class="to">Aadhar ID </label>-->
                                        <!--                                                </div>-->
                                        <!--                                                <div class="col-xs-7 col-sm-7 col-md-6 ">-->
                                        <!--                                                    <label class="tp">--><?php //echo strtolower($part_user['email']); ?><!--</label>-->
                                        <!--                                                </div>-->
                                        <!--                                            </div>-->
                                        <!--                                        </div>-->
                                        <!-- 6 row ENDS-->
                                        <!-- 7 row begins-->
                                        <!--                                        <div class="row clearfix">-->
                                        <!--                                            <div class="col-xs-12 col-sm-6 col-md-6">-->
                                        <!--                                                <div class="col-xs-5 col-sm-5 col-md-4 ">-->
                                        <!--                                                    <label class="to">Aadhar FRONT </label>-->
                                        <!--                                                </div>-->
                                        <!--                                                <div class="col-xs-7 col-sm-7 col-md-6 ">-->
                                        <!--                                                    <label class="tp">image</label>-->
                                        <!--                                                </div>-->
                                        <!--                                            </div>-->
                                        <!--                                            <div class="col-xs-12 col-sm-6 col-md-6 ">-->
                                        <!--                                                <div class="col-xs-5 col-sm-5 col-md-4 ">-->
                                        <!--                                                    <label class="to">Aadhar BACK </label>-->
                                        <!--                                                </div>-->
                                        <!--                                                <div class="col-xs-7 col-sm-7 col-md-6 ">-->
                                        <!--                                                    <label class="tp">image</label>-->
                                        <!--                                                </div>-->
                                        <!--                                            </div>-->
                                        <!--                                        </div>-->
                                        <!-- 7 row ENDS-->
                                        <!--                                        <hr style="margin-top: 0px;">-->
                                        <!---->
                                        <!-- 8 row begins  -->
                                        <!--                                        <div class="row clearfix">-->
                                        <!--                                            <div class="col-md-12" style="margin-bottom 0px;">-->
                                        <!--                                                <div class="col-md-3">-->
                                        <!--                                                    <label class="to"> Permanent Address</label>-->
                                        <!--                                                </div>-->
                                        <!--                                                <div class="col-md-9">-->
                                        <!--                                                    <label class="tp"> Near Kashiva House Rathore Lane , Sirohi , Sirohi-->
                                        <!--                                                        , Rajasthan - 307001 </label>-->
                                        <!--                                                </div>-->
                                        <!--                                            </div>-->
                                        <!--                                        </div>-->
                                        <!-- 8 row ends -->
                                        <!---->
                                        <!-- 8 row begins  -->
                                        <!--                                        <div class="row clearfix">-->
                                        <!--                                            <div class="col-md-12" style="margin-bottom 0px;">-->
                                        <!--                                                <div class="col-md-3">-->
                                        <!--                                                    <label class="to"> Corresponding Address</label>-->
                                        <!--                                                </div>-->
                                        <!--                                                <div class="col-md-9">-->
                                        <!--                                                    <label class="tp"> Near Kashiva House Rathore Lane , Sirohi , Sirohi-->
                                        <!--                                                        , Rajasthan - 307001 </label>-->
                                        <!--                                                </div>-->
                                        <!--                                            </div>-->
                                        <!--                                        </div>-->
                                        <!-- 8 row ends -->
                                        <!--                                        <hr style="margin-top: 0px;">-->
                                        <!--                                        <div class="row clearfix" style="padding-top: 10px;">-->
                                        <!---->
                                        <!--                                            <div class="col-md-1 ton" style="text-align: center;">-->
                                        <!---->
                                        <!--                                                Exam-->
                                        <!---->
                                        <!--                                            </div>-->
                                        <!--                                            <div class="col-md-3 ton">-->
                                        <!---->
                                        <!--                                                Institution Name-->
                                        <!---->
                                        <!--                                            </div>-->
                                        <!--                                            <div class="col-md-2 ton">-->
                                        <!---->
                                        <!--                                                Institution City-->
                                        <!---->
                                        <!--                                            </div>-->
                                        <!--                                            <div class="col-md-1 ton">-->
                                        <!---->
                                        <!--                                                Board-->
                                        <!---->
                                        <!--                                            </div>-->
                                        <!--                                            <div class="col-md-1 ton">-->
                                        <!---->
                                        <!--                                                Year-->
                                        <!---->
                                        <!--                                            </div>-->
                                        <!--                                            <div class="col-md-2 ton">-->
                                        <!---->
                                        <!--                                                Roll No-->
                                        <!---->
                                        <!--                                            </div>-->
                                        <!--                                            <div class="col-md-1 ton">-->
                                        <!---->
                                        <!--                                                Max.-->
                                        <!---->
                                        <!--                                            </div>-->
                                        <!--                                            <div class="col-md-1 ton">-->
                                        <!---->
                                        <!--                                                Obt.-->
                                        <!---->
                                        <!--                                            </div>-->
                                        <!---->
                                        <!---->
                                        <!--                                            <div class="col-md-1 ton" style="text-align: center;">-->
                                        <!---->
                                        <!--                                                X-->
                                        <!---->
                                        <!--                                            </div>-->
                                        <!---->
                                        <!---->
                                        <!--                                            <div class="col-md-3">-->
                                        <!--                                                <label class="tp"> Emmanuel Mission School </label>-->
                                        <!--                                            </div>-->
                                        <!--                                            <div class="col-md-2">-->
                                        <!--                                                <label class="tp"> Sirohi </label>-->
                                        <!--                                            </div>-->
                                        <!--                                            <div class="col-md-1">-->
                                        <!--                                                <label class="tp"> RBSE </label>-->
                                        <!--                                            </div>-->
                                        <!--                                            <div class="col-md-1">-->
                                        <!--                                                <label class="tp"> 2013 </label>-->
                                        <!--                                            </div>-->
                                        <!--                                            <div class="col-md-2">-->
                                        <!--                                                <label class="tp"> 0913102 </label>-->
                                        <!--                                            </div>-->
                                        <!--                                            <div class="col-md-1">-->
                                        <!--                                                <label class="tp"> 600 </label>-->
                                        <!--                                            </div>-->
                                        <!--                                            <div class="col-md-1">-->
                                        <!--                                                <label class="tp"> 540 </label>-->
                                        <!--                                            </div>-->
                                        <!---->
                                        <!--                                            <hr style="margin-top: 0px;" class="col-md-10 col-md-offset-1">-->
                                        <!---->
                                        <!--                                            <div class="col-md-1 ton" style="text-align: center;">-->
                                        <!---->
                                        <!--                                                XI-->
                                        <!---->
                                        <!--                                            </div>-->
                                        <!---->
                                        <!--                                            <div class="col-md-3">-->
                                        <!--                                                <label class="tp"> St Paul's School </label>-->
                                        <!--                                            </div>-->
                                        <!--                                            <div class="col-md-2">-->
                                        <!--                                                <label class="tp"> Sirohi </label>-->
                                        <!--                                            </div>-->
                                        <!--                                            <div class="col-md-1">-->
                                        <!--                                                <label class="tp"> CBSE </label>-->
                                        <!--                                            </div>-->
                                        <!--                                            <div class="col-md-1">-->
                                        <!--                                                <label class="tp"> 2014 </label>-->
                                        <!--                                            </div>-->
                                        <!--                                            <div class="col-md-2">-->
                                        <!--                                                <label class="tp"> - </label>-->
                                        <!--                                            </div>-->
                                        <!--                                            <div class="col-md-1">-->
                                        <!--                                                <label class="tp"> - </label>-->
                                        <!--                                            </div>-->
                                        <!--                                            <div class="col-md-1">-->
                                        <!--                                                <label class="tp"> - </label>-->
                                        <!--                                            </div>-->
                                        <!---->
                                        <!---->
                                        <!--                                            <div class="col-md-1 ton" style="text-align: center;">-->
                                        <!--                                                XII-->
                                        <!--                                            </div>-->
                                        <!---->
                                        <!--                                            <div class="col-md-3">-->
                                        <!--                                                <label class="tp"> St Paul's School </label>-->
                                        <!--                                            </div>-->
                                        <!--                                            <div class="col-md-2">-->
                                        <!--                                                <label class="tp"> Sirohi </label>-->
                                        <!--                                            </div>-->
                                        <!--                                            <div class="col-md-1">-->
                                        <!--                                                <label class="tp"> CBSE </label>-->
                                        <!--                                            </div>-->
                                        <!--                                            <div class="col-md-1">-->
                                        <!--                                                <label class="tp"> 2015 </label>-->
                                        <!--                                            </div>-->
                                        <!--                                            <div class="col-md-2">-->
                                        <!--                                                <label class="tp"> 1664388 </label>-->
                                        <!--                                            </div>-->
                                        <!--                                            <div class="col-md-1">-->
                                        <!--                                                <label class="tp"> 500 </label>-->
                                        <!--                                            </div>-->
                                        <!--                                            <div class="col-md-1">-->
                                        <!--                                                <label class="tp"> 466 </label>-->
                                        <!--                                            </div>-->
                                        <!---->
                                        <!--                                            <hr style="margin-top: 0px;" class="col-md-10 col-md-offset-1">-->
                                        <!--                                            <div class="col-md-1 ton" style="text-align: center;">-->
                                        <!---->
                                        <!--                                                Diploma-->
                                        <!---->
                                        <!--                                            </div>-->
                                        <!---->
                                        <!--                                            <div class="col-md-3">-->
                                        <!--                                                <label class="tp"> - </label>-->
                                        <!--                                            </div>-->
                                        <!--                                            <div class="col-md-2">-->
                                        <!--                                                <label class="tp"> - </label>-->
                                        <!--                                            </div>-->
                                        <!--                                            <div class="col-md-1">-->
                                        <!--                                                <label class="tp"> - </label>-->
                                        <!--                                            </div>-->
                                        <!--                                            <div class="col-md-1">-->
                                        <!--                                                <label class="tp"> - </label>-->
                                        <!--                                            </div>-->
                                        <!--                                            <div class="col-md-2">-->
                                        <!--                                                <label class="tp"> - </label>-->
                                        <!--                                            </div>-->
                                        <!--                                            <div class="col-md-1">-->
                                        <!--                                                <label class="tp"> - </label>-->
                                        <!--                                            </div>-->
                                        <!--                                            <div class="col-md-1">-->
                                        <!--                                                <label class="tp"> - </label>-->
                                        <!--                                            </div>-->
                                        <!---->
                                        <!--                                        </div>-->
                                        <!---->
                                        <!--                                        <hr style="margin-top: 0px;">-->
                                        <!---->
                                        <!---->
                                        <!--                                    </div>-->
                                        <!---->
                                        <!---->
                                        <!--                                </div>-->
                                        <!--END tab profile-->
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
<!--                    end profile detail-->
                </div>
            </div>
            <?php
            $date_year_check = $today_date_year;                          // getting current year
            if (isset($_REQUEST['show_my_task_year'])) {                    // checking if you want to look for different year
                $date_year_check = $_REQUEST['show_my_task_year'];
            }
            ?>
            <!--  All tasks -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                User Tasks
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right" >
                                        <li><a id="buttonsEx"></a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <!--                    <div class="col-sm-6"></div>-->
                        <div class="body">
                            <div class="table-responsive">
                                <table id="task_list"  class="table table-bordered table-striped table-hover dataTable show-all-task">
                                    <thead>
                                    <tr style="font-weight: bold; background: #607d8b; color: white">
                                        <th>INTERN</th>
                                        <th>TITLE</th>
                                        <th>PROJECT</th>
                                        <th>CREATED AT</th>
                                        <th>PROJ STATUS</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr style="font-weight: bold; background: #607d8b; color: white; table-layout: fixed">
                                        <th>INTERN</th>
                                        <th>TITLE</th>
                                        <th>PROJECT</th>
                                        <th>CREATED AT</th>
                                        <th>PROJ STATUS</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- #END#  All tasks -->

        </div>
    </div>
</section>

<!-- ----------------------------------------- END HTML BODY ------------------------------------------------------------ -->

<!-- -----------------------------------------HTML FOOTER--------------------------------------------------------------- -->
<?php require_once(INCLUDE_PATH . '/layouts/_footer.php'); ?>

<!-- Custom Js -->
<!-- Demo Js for skin color etc-->
<!--<script src="--><?php //echo $asset_path_link ?><!--assets/bsb/js/demo.js"></script>-->
<!-- Custom Jquery DataTables-->
<script type="text/javascript">

    $(function () {

        var table =  $('.show-all-task').DataTable({
            ajax: "<?php echo $adm_pages_link?>"+"task_logics.php?&dtShowUserTasks="+"task_list&selectedYear="+ <?php echo $date_year_check?> + "&user_id=" + <?php echo $uid?>,
            columns: [
                { "data": "tk_title" },
                { "data": "tk_project" },
                { "data": "team_name" },
                { "data": "formatted_initiate" },
                { "data": "tk_status" }
            ],
            deferRender: true,
            scrollY   : '60vh',                    // vertical port view
            "scrollX": true,
            "autoWidth": false,
            responsive: true,
            scrollCollapse: true,                // cause DataTables to collapse the table's viewport when the result set fits within the given Y height.
            order: [[1, 'asc'],[0, 'asc']],
            // rowGroup: {
            //     dataSrc: 'le_status'                 // row grouping based on column
            // },
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'B><'col-sm-12 col-md-4 pull-right'p>>",
            // column visibility button
            buttons: [
                {
                    extend: 'colvis',
                    columns: ':not(.noVis)'
                },
            ],
            columnDefs: [
                // {
                //     targets: 2,
                //     render: function (data, type, row) {
                //         return data.substr(0, 100);
                //     }
                // },
                {
                    targets: 1,
                    className: 'noVis',
                },
            ],
            rowCallback: function(row, data){
                $(row).find('td:eq(0)').addClass(data['dt_row_color_class']);
                $(row).find('td:eq(4)').addClass(data['tk_status_color']);
                $(row).find('td:eq(0)').addClass('font-bold');
                $(row).find('td:eq(4)').addClass('font-bold');
            }

        });
        // document.getElementById('app_title').text = 'TASKS';
        // to show export buttons in header dropdown.
        var buttons = new $.fn.dataTable.Buttons(table, {
            buttons: [
                'copy', 'csv', 'excel',
                {
                    extend: 'print',
                    text: 'Preview',
                    autoPrint: false,
                    messageTop: 'This print was produced using the cdac ims',
                    exportOptions: {
                        columns: ':visible'
                    },
                    customize: function (win) {
                        // $(win.document.body).find('table').addClass('display');
                        $(win.document.body).find('tr:nth-child(odd) td').each(function(index){
                            $(this).css('background-color','#D0D0D0');
                        });
                        $(win.document.body).find('h1').css('text-align','center');
                        $(win.document.body).find('h1').text('<?php echo APP_TITLE ?> - TASKS');
                        $(win.document.body)
                            .css( 'font-size', '12pt' )
                            .prepend(
                                '<img src="http://datatables.net/media/images/logo-fade.png" style="position:absolute; top:0; left:0;" />'
                            );

                        $(win.document.body).find( 'table' )
                            .addClass( 'compact' )
                            .css( 'font-size', 'inherit' )
                        ;
                        // .css( 'margin', '0 auto' )
                        // .css( 'width', '100%' )
                        // .css( 'clear', 'both' )
                        // .css( 'border-collapse', 'collapse' )
                        // .css( 'table-layout', 'fixed' )
                        // .css( 'word-wrap', 'break-word' );

                    },

                },
            ],
        }).container().appendTo($('#buttonsEx'));

        // on click to open new
        $('.show-all-task tbody').on('click', 'tr', function () {
            var data = table.row(this).data();
            // console.log( table.row( this ).data() );
            // console.log( data['user_id'] );
            window.open(
                "<?php echo $adm_pages_link?>"+data['url'],
                '_blank' // <- This is what makes it open in a new window.
            );
        });
    });
    // render buttons as button tag
    $.fn.dataTable.Buttons.defaults.dom.button.tag = 'button';

</script>
<?php //echo $uid ?>
<!-- ------------------------------------------END HTML FOOTER --------------------------------------------------------------- -->
</html>
<!--                    <div class="col-xs-12 col-sm-9">-->
<!--                        <div class="card card-about-me">-->
<!--                            <div class="header">-->
<!--                                <h2>TECH</h2>-->
<!--                            </div>-->
<!--                            <div class="body">-->
<!--                                <ul>-->
<!--                                    <li>-->
<!--                                        <div class="title">-->
<!--                                            <i class="material-icons">library_books</i>-->
<!--                                            Projects-->
<!--                                        </div>-->
<!--                                        <div class="content">-->
<!--                                            projects worked on-->
<!--                                            <ul>-->
<!--                                                <li>1</li>-->
<!--                                            </ul>-->
<!--                                        </div>-->
<!--                                    </li>-->
<!--                                    <li>-->
<!--                                        <div class="title">-->
<!--                                            <i class="material-icons">edit</i>-->
<!--                                            Skills-->
<!--                                        </div>-->
<!--                                        <div class="content">-->
<!--                                            <span class="label bg-red">UI Design</span>-->
<!--                                            <span class="label bg-teal">JavaScript</span>-->
<!--                                            <span class="label bg-blue">PHP</span>-->
<!--                                            <span class="label bg-amber">Node.js</span>-->
<!--                                            <span class="label bg-black">Python</span>-->
<!--                                        </div>-->
<!--                                    </li>-->
<!--                                </ul>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->