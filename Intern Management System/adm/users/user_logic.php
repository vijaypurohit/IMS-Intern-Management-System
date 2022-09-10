<?php
/**
 * Created by PhpStorm.
 * User: Vijay Purohit
 * Date: 5/23/2019
 * Time: 2:02 PM
 * Project: ims_vj
 *
 */
$asset_path_link='../../';
require_once($asset_path_link.'config.php');
require_once(INCLUDE_PATH . "/logic/common_functions.php");

// datatable show all users
if(isset($_REQUEST['dtShowAllUsers']) && $_REQUEST['dtShowAllUsers']=='user_list') {
    $all_users = getUserRoleProfileOfAll();
//    $data[] = "data";
    $tot_allUsers = count($all_users);
    $data = array();
    for ($i = 0; $i < $tot_allUsers; $i++) {
//    foreach ($all_users as $au) {
        $au=$all_users[$i];

        $color_text = 'col-red';
        if ($au['role'] == 'Administrator')
            $color_text = 'col-red';
        elseif ($au['role'] == 'Manager')
            $color_text = 'col-blue';
        elseif ($au['role'] == 'Employee')
            $color_text = 'col-orange';
        else
            $color_text = 'col-green';

        $d = new DateTime($au['created_at']);
        $formatted_date = $d->format('M, d Y'); // 05-Sep-2018
        $formatted_time = $d->format('h:i A'); // 11:18 AM


        $data[$i]['full_name']=ucwords($au['full_name']) ;
        $data[$i]['email']=strtolower($au['email']);
        $data[$i]['role']=strtoupper($au['role']);
        $data[$i]['created_at']=$formatted_date . " | " . $formatted_time ;
        $data[$i]['user_id']=$au['uid'] ;
        $data[$i]['dt_row_color_class']=$au['dt_row_color_class'] ;

    } // end of for loop

    $results = array(
        "TotalRecords" => count($all_users),
        "data"=>$data
    );
    echo json_encode($results);
    return;
}

// Creation of User by Admin
if (isset($_REQUEST['save_user']) ) {


    $username = $_REQUEST['username'];
    $email = $_REQUEST['email'];
    $email = strtolower($email);

//    echo " us = ".$username;
//    echo " e = ".$email;

    $oldUser = checkUserNameEmail($email,$username);
    // if request is from javascript to check validation of uniqueness and error is found
    if (!empty($oldUser['username']) && $oldUser['username'] === $username) { // if user exists
        $_SESSION['msg'] = "Username already exists";
        $_SESSION['msg_color'] = 'bg-orange';
        echo "false";
        return;
    }
    if (!empty($oldUser['email']) && $oldUser['email'] === $email) { // if email exists
        $_SESSION['msg'] = "Email already exists";
        $_SESSION['msg_color'] = 'alert-warning';
        echo "false";
        return;
    }
    // if request is from javascript to check validation and no error is found
    if(isset($_REQUEST['checkunique']) && $_REQUEST['checkunique']=="yes" ){
        echo "true";
        return;
    }

    if (!preg_match('/^[\w]+$/i', $username)) {
        $_SESSION['msg'] = "Letters, numbers, and underscores only please";
        $_SESSION['msg_color'] = 'alert-warning';
        return;
    }


    if(empty($_REQUEST['username']) || empty($_REQUEST['password'])  || empty($_REQUEST['confirm']) || empty($_REQUEST['email'])  || empty($_REQUEST['full_name']) || empty($_REQUEST['role_id']) ){
        $errors['required'] = "All the fields are required!";
//        var_dump($errors);
        $_SESSION['msg_array'] = $errors;
        $_SESSION['msg_array_color'] = 'bg-teal';
        return ;
    }

//    var_dump($_REQUEST);
//    return;

    $password = $_REQUEST['password'];
    $confirm = $_REQUEST['confirm'];
    $role_id = $_REQUEST['role_id'];
    $full_name = $_REQUEST['full_name'];
    $full_name = ucwords($full_name);

    // password confirmation
    if (isset($confirm) && ($password !== $confirm)) {
        $errors['passwordConf'] = "The two passwords do not match.";
//        var_dump($errors);
        $_SESSION['msg_array'] = $errors;
        $_SESSION['msg_array_color'] = 'alert-warning';
        return ;
    }// END password confirmation

    // if everything is great then
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // returns last insert id
    $result = insertUser($role_id, $username,$email,$password_hash);
    if($result){
        $_SESSION['msg'] = 'New User - '.$username.' - is created Successfully';
        $_SESSION['msg_color'] = 'alert-success';
        $new_user = getUserUid($username);
        insertProfileName($new_user['id'],$full_name);
    }else {
        $_SESSION['msg'] = 'Error in creating new user';
        $_SESSION['msg_color'] = 'alert-danger';
    }
    unset($_REQUEST['save_user']);
    return;
} // END Update password

// disable the user
if(isset($_REQUEST['disable_user']) && $_REQUEST['disable_user']=='user_profile_view' ){
    $used_id_to_disable = $_REQUEST['used_id_to_disable'];
    $actionTaken        = $_REQUEST['value_s'];
    $actionTakenString        = $_REQUEST['value_string'];
    $byUserId           = $_REQUEST['by_id'];
    $used_name_to_disable           = $_REQUEST['used_name_to_disable'];

   $result = disableUserSignIn($used_id_to_disable, $actionTaken, $byUserId);

    if($result){
        $_SESSION['msg'] = "'".$used_name_to_disable."' is ".$actionTakenString."D Successful";
        $_SESSION['msg_color'] =  'alert-success';

    }else{
        $_SESSION['msg'] = 'Error!!';
        $_SESSION['msg_color'] =  'alert-danger';
    }

    unset($_REQUEST['disable_user']);
    return;
}

// disable the user
if(isset($_REQUEST['reset_user']) && $_REQUEST['reset_user']=='user_profile_view_reset_user' ){
    $user_id_to_reset = $_REQUEST['user_id_to_reset'];
    $byUserId           = $_REQUEST['by_id'];
    $user_name_to_reset          = $_REQUEST['user_name_to_reset'];
    $_REQUEST['uid']          = $user_id_to_reset;

    $password_hash = password_hash($user_name_to_reset, PASSWORD_DEFAULT);

    $result = resetUserSignIn($user_id_to_reset, $password_hash, $byUserId);

    if($result){
        $_SESSION['msg'] = "'".$user_name_to_reset."' password is Reset Successful [pass-$user_name_to_reset]";
        $_SESSION['msg_color'] =  'alert-success';

    }else{
        $_SESSION['msg'] = 'Error!!';
        $_SESSION['msg_color'] =  'alert-danger';
    }

        echo ("<script language='javascript'>
           window.location.href='user_profile_view.php?uid='+$user_id_to_reset;
        </script>");

    unset($_REQUEST['reset_user']);
    return;
}

// input field form name
// then greeting me naam