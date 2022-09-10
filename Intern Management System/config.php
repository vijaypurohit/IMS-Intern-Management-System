<?php
/**
 * Created by PhpStorm.
 * User: vijay
 * Date: 16-May-19
 * Time: 11:25 AM
 */

// Session
//session_save_path('/');
//ini_set('session.gc_probability', 1);
    ob_start();

    session_start(); // start session
//    require_once('includes/layouts/_session.php');

/*  Error Reporting
         * Turn off all error reporting = 0
         *  Report all PHP errors = -1
         *  Report all PHP errors (see changelog)
        */
    //error_reporting(E_ALL);
    //error_reporting(0);

// TimeZone
    date_default_timezone_set('Asia/Calcutta');

// DB PARAMETERS
    require_once('includes/layouts/_connect.php');

// PROJECT URLs
    if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) $uri = 'https://';
    else   $uri = 'http://';

    $uri .= $_SERVER['HTTP_HOST'];
    $folder_name =  '/ims_vj';     // main project folder name
    $upload_profile_fol_name =  '/profile_img/';
    $upload_editor_fol_name =  '/editors/';
    $upload_sign_fol_name =  '/profile_img/'; //user_sign
    // define global path constants
        define ('ROOT_PATH', realpath(dirname(__FILE__))); // path to the root folder
        define ('INCLUDE_PATH', realpath(dirname(__FILE__) . '/includes' )); // Path to includes folder
        define ('ADM_PATH', realpath(dirname(__FILE__) . '/adm' )); // Path to includes adm files
        define ('INT_PATH', realpath(dirname(__FILE__) . '/int' )); // Path to includes intern files
        define ('UPLOAD_URL', $uri.$folder_name . '/uploads' ); // Path to show uploads images
        define('BASE_URL', $uri.$folder_name); // the home url of the website

// SMS KEYs
    define("sms_authKey", "");
    define("sms_senderId", "NETCOM");
    define("sms_routeId", "0");
    define("sms_url", "");
    define("sms_development_mode", "1");    //  for developing and testing use 1 and your number
    define("sms_developer_no", "123456789");

// PARA
    define('APP_TITLE',"CDAC ATC IMS");
    define('APP_TITLE0',"CDAC");
    define('APP_TITLE1',"IMS");
    define('APP_NAV_NAME',"CDAC ATC JAIPUR IMS");
    define('APP_USER_DESIG',"CDAC ATC JAIPUR");
    define('APP_CopyRightYEAR',"2019-2020");
    define('APP_VS',"&#x03B2.1.1");


//INSERT INTO `users` (`id`, `role_id`, `username`, `email`, `password`, `created_at`, `updated_at`, `c_status`, `action_by_id`) VALUES (NULL, '5', 'vijayp', 'vijay@ims.com', '$2y$10$GBO5Iw1iZJxvZZbntWwmm.d/GlCzyMJkTCPcbU75icaPU1U.ChcT2', CURRENT_TIMESTAMP, '0000-00-00 00:00:00.000000', '1', NULL);
//INSERT INTO `profiles` (`id`, `user_id`, `full_name`, `profile_picture`, `user_sign`) VALUES (NULL, '1', 'Vijay Purohit', NULL, NULL);

//

