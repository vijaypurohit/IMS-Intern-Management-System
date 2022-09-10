<?php
/**
 * Created by PhpStorm.
 * User: Vijay Purohit
 * Date: 5/23/2019
 * Time: 11:03 AM
 * Project: ims_vj
 */

$asset_path_link='../../';
$adm_pages_link='../';

$bootstrap_select=1;
$jqueryValidate=1;

?>
<?php  require_once($asset_path_link.'config.php'); ?>
<?php  require_once (ADM_PATH .'/_.php'); ?>
<?php  require_once('user_logic.php'); ?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2 class="com bo"
                style="text-align: center; font-size: 20px; letter-spacing: 2px; padding-bottom: 5px;">
                USER REGISTRATION
            </h2>
        </div>
<?php  include(INCLUDE_PATH . '/layouts/_messages.php'); ?>
        <!-- FIRST ROW -->
        <div class="row clearfix">
            <div class="col-xs-10 col-sm-10 col-md-6 col-lg-6" >
            <div class="signup-box">

                <div class="card " style="position: center">
                    <div class="body">
                        <form id="sign_up" method="POST">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">person</i>
                                </span>
                                <div class="form-line">
                                    <input type="text" class="form-control" name="username" id="username_r" placeholder="UserName" autocomplete="off" required autofocus>
                                </div>
                                <div class="help-info">Unique UserName</div>
                            </div><!--username-->
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">email</i>
                                </span>
                                <div class="form-line">
                                    <input type="email" class="form-control" name="email" id="email_r" placeholder="Email Address" autocomplete="off"  required>
                                </div>
                                <div class="help-info">Unique Email Id</div>
                            </div><!--email-->
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">lock</i>
                                </span>
                                <div class="form-line">
                                    <input type="password" class="form-control" name="password" minlength="4" placeholder="Password" required>
                                </div>
                            </div><!--password-->
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">vpn_key</i>
                                </span>
                                <div class="form-line">
                                    <input type="password" class="form-control" name="confirm" minlength="4" placeholder="Confirm Password" required>
                                </div>
                            </div><!--password confirmation-->
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">face</i>
                                </span>
                                <div class="form-line">
                                    <input type="text" class="form-control" name="full_name" placeholder="Full Name" autocomplete="off" required>
                                </div>
                            </div><!--full name-->
                            <div class="row clearfix">
                                <div class="col-sm-12 col-md-12">
                                    <select class="form-control show-tick" name="role_id" data-show-subtext="true">
                                        <?php
                                            $roles = getAllRoles();
                                            foreach ($roles as $r) {
                                                if ($r['folder_name'] == 'int')
                                                    echo "<option data-divider='true'></option>";
                                                echo "<option value='$r[id]' data-subtext='$r[description]' style='text-overflow: ellipsis '>$r[name]</option>";
                                            }
                                        ?>
                                    </select>
                                    </div>
                            </div><!--roles-->
                            <button class="btn btn-block btn-lg bg-deep-purple waves-effect" name="save_user" type="submit">CREATE</button>
                            <div class="m-t-25 m-b--5 align-center">USER can sign in using username or email.
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            </div>
        </div>

        <!-- END FIRST ROW -->
    </div>
</section>

<!-- ----------------------------------------- END HTML BODY ------------------------------------------------------------ -->


<!-- -----------------------------------------HTML FOOTER--------------------------------------------------------------- -->
<?php require_once (INCLUDE_PATH .'/layouts/_footer.php'); ?>

<!-- Custom Js -->
<!-- Demo Js for skin color etc-->
<!--<script src="--><?php //echo $asset_path_link ?><!--assets/bsb/js/demo.js"></script>-->
<!-- User Registration-->
<script src="<?php echo $asset_path_link ?>assets/bsb/js/pages/examples/sign-up.js"></script>
<!--<script src="../../assets/bsb/plugins/autosize/autosize.js"></script>-->

<!-- ------------------------------------------END HTML FOOTER --------------------------------------------------------------- -->
</html>