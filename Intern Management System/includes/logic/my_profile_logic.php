<?php
/**
 * Created by PhpStorm.
 * User: Vijay Purohit
 * Date: 5/22/2019
 * Time: 12:54 PM
 * Project: ims_vj
 */

if(isset($_REQUEST['asset_path_link_i']))
    $asset_path_link=$_REQUEST['asset_path_link_i'];

require_once($asset_path_link.'config.php');
require_once(INCLUDE_PATH . "/logic/common_functions.php");
require_once(INCLUDE_PATH . "/logic/SimpleImage.php");

$user_s_mpl = $_SESSION['user'];
$userId = $user_s_mpl['id'];
$errors  = [];


if (isset($_REQUEST['update_pass']) ) {
    $prevPasswordHash=$user_s_mpl['password'];
    $OldPassword = $_REQUEST['OldPassword'];             // this can be either username or email

// if request is from javascript to check validation of uniqueness and error is found
// if passwordOld was sent, then verify old password
    //        $oldUser = getUserAllDetails($user_s_mpl['id']);
    //        $prevPasswordHash = $oldUser['password'];
    if (!password_verify($OldPassword, $prevPasswordHash)) {
        $errors['passwordOld'] = "The old password does not match.";
        $_SESSION['msg_array'] = $errors;
        $_SESSION['msg_array_color'] = 'alert-danger';
        echo "false";
        return;
    }// END password old
    // if request is from javascript to check validation and no error is found
    if(isset($_REQUEST['checkold']) && $_REQUEST['checkold']=="yes" ){
        echo "true";
        return;
    }

    if(empty($_REQUEST['OldPassword']) || empty($_REQUEST['NewPassword']) || empty($_REQUEST['NewPasswordConfirm']) ){
        $errors['required'] = "All the fields are required!";
        $_SESSION['msg_array'] = $errors;
        $_SESSION['msg_array_color'] = 'bg-teal';
        return ;
    }

    $NewPassword = $_REQUEST['NewPassword'];
    $NewPasswordConfirm = $_REQUEST['NewPasswordConfirm'];

    // password confirmation
    if (isset($NewPasswordConfirm) && ($NewPassword !== $NewPasswordConfirm)) {
        $errors['passwordConf'] = "The new passwords do not match.";
        $_SESSION['msg_array'] = $errors;
        $_SESSION['msg_array_color'] = 'alert-warning';
        return ;
    }// END password confirmation

    // if everything is great then
    $password = password_hash($NewPassword, PASSWORD_DEFAULT);

    $result = updateUserPassword($password,$user_s_mpl['id']);
    if($result){
        $_SESSION['msg'] = 'Password is updated successfully, Logging Out.';
        $_SESSION['msg_color'] = 'alert-success';

        echo ("<script language='javascript'>
           setTimeout(function(){window.location.href='_logout.php'; }, 1500);
            
        </script>");
    }else {
        $_SESSION['msg'] = 'Error in updating Password';
        $_SESSION['msg_color'] = 'alert-danger';
    }

} // END Update password

if (isset($_REQUEST['update_picture']) ) {
    global $upload_profile_fol_name;
    $allowedMimeTypes = array(image_type_to_mime_type(IMAGETYPE_PNG),image_type_to_mime_type( IMAGETYPE_JPEG));

    if (!empty($_FILES) && !empty($_FILES['profile_picture']['name'])) {

        //Put file properties into variables
        $file = $_FILES['profile_picture']['name'];
        $file_size = filesize($_FILES['profile_picture']['tmp_name']);
        $file_tmp_name = $_FILES['profile_picture']['tmp_name'];

        // Default extension
        $default = pathinfo($file, PATHINFO_EXTENSION);
        // create special string from date to ensure filename is unique
        $date = date("Y-m-d H:i:s");
        $uploadtime = strtotime($date);
        $file_upload_name = $uploadtime."-".$user_s_mpl['username'].".".$default;

        $er=0;
        // checking if it is a valid image.
        $returnedMime = getMimeType($file_tmp_name);
        if(!in_array($returnedMime, $allowedMimeTypes)) {
            $_SESSION['msg_array'][] = "Please Input a Valid Image (png, jpg).";
            $_SESSION['msg_array_color'] = 'bg-teal';
            $er = 1;
        }
        // checking size of the image.
        if($file_size > 5242880) { //5 MB (size is also in bytes)
            $_SESSION['msg_array'][] = "File Too Big ( > 5MB ).";
            $_SESSION['msg_array_color'] = 'bg-teal';
            $er = 1;

        }
        if($er)return;


        // define Where image will be stored
        $target = ROOT_PATH . "/uploads".$upload_profile_fol_name . $file_upload_name;
        // upload image to folder
        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target)) {

            store_uploaded_image($target, '512', '512');

            $result = insertProfilePictureName($userId, $file_upload_name);

            if($result) {
                $_SESSION['msg'] = "Image Uploaded. Refresh to See the changes.";
                $_SESSION['msg_color'] = 'alert-success';
            }
            else{
                $_SESSION['msg'] = "Unexpected Error";
                $_SESSION['msg_color'] = 'alert-danger';
            }
            return ;

        }else{
            $_SESSION['msg'] = "Failed to upload image.";
            $_SESSION['msg_color'] = 'alert-danger';
            return ;
        }
    }
    else{
//        var_dump($errors);
        $_SESSION['msg'] = "No Image Uploaded.";
        $_SESSION['msg_color'] = 'alert-warning';
        return;
    }

//    $profile_picture_name = uploadProfilePicture();
}

if (isset($_REQUEST['update_sign_submit']) ) {
    global $upload_profile_fol_name;
    $allowedMimeTypes = array(image_type_to_mime_type(IMAGETYPE_PNG),image_type_to_mime_type( IMAGETYPE_JPEG));

    if (!empty($_FILES) && !empty($_FILES['user_sign_input']['name'])) {

        //Put file properties into variables
        $file = $_FILES['user_sign_input']['name'];
        $file_size = filesize($_FILES['user_sign_input']['tmp_name']);
        $file_tmp_name = $_FILES['user_sign_input']['tmp_name'];

        // Default extension
        $default = pathinfo($file, PATHINFO_EXTENSION);
        // create special string from date to ensure filename is unique
        $date = date("Y-m-d H:i:s");
        $uploadtime = strtotime($date);
        $file_upload_name = $uploadtime."-".$user_s_mpl['username']."_sign.".$default;

        $er=0;
        // checking if it is a valid image.
        $returnedMime = getMimeType($file_tmp_name);
        if(!in_array($returnedMime, $allowedMimeTypes)) {
            $_SESSION['msg_array'][] = "Please Input a Valid Image (png, jpg).";
            $_SESSION['msg_array_color'] = 'bg-teal';
            $er = 1;
        }
        // checking size of the image.
        if($file_size > 2097152) { //2 MB (size is also in bytes)
            $_SESSION['msg_array'][] = "File Too Big ( > 2MB ).";
            $_SESSION['msg_array_color'] = 'bg-teal';
            $er = 1;
        }
        if($er)return;


        // define Where image will be stored
        $target = ROOT_PATH . "/uploads".$upload_profile_fol_name . $file_upload_name;
        // upload image to folder
        if (move_uploaded_file($_FILES['user_sign_input']['tmp_name'], $target)) {

            store_uploaded_image($target, '280', '80');


            $result = insertUserSignName($userId, $file_upload_name);//$userId

            if($result) {
                $_SESSION['msg'] = "Image Uploaded. Refresh to see the Changes.";
                $_SESSION['msg_color'] = 'alert-success';
            }
            else{
                $_SESSION['msg'] = "Unexpected Error";
                $_SESSION['msg_color'] = 'alert-danger';
            }
            return ;

        }else{
            $_SESSION['msg'] = "Failed to upload image.";
            $_SESSION['msg_color'] = 'alert-danger';
            return ;
        }
    }
    else{
//        var_dump($errors);
        $_SESSION['msg'] = "No Image Uploaded.";
        $_SESSION['msg_color'] = 'alert-warning';
        return;
    }

//    $profile_picture_name = uploadProfilePicture();
}


function store_uploaded_image($file_tmp_name, $new_img_width, $new_img_height) {
    $target_file = $file_tmp_name;
    $image = new SimpleImage();
    $image->load($file_tmp_name);
    $image->resize($new_img_width, $new_img_height);
    $image->save($target_file);
    return $target_file; //return name of saved file in case you want to store it in you database or show confirmation message to user
}


//if (isset($_REQUEST['unique_change']) && !$_REQUEST['unique_change']=='' ) {
//    $username = $_REQUEST['username'];             // this can be either username or email
//    $email = $_REQUEST['email'];
//
//
//    if(empty($_REQUEST['username']) || empty($_REQUEST['email']) ){
//        $errors['required'] = "All the fields are required!";
////        var_dump($errors);
//        $_SESSION['msg_array'] = $errors;
//        $_SESSION['msg_array_color'] = 'bg-teal';
//        return ;
//    }
//}