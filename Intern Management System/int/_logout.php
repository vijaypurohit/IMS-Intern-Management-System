<?php
/**
 * Created by PhpStorm.
 * User: Vijay Purohit
 * Date: 5/21/2019
 * Time: 2:08 PM
 * Project: ims_vj
 */
session_start();
session_destroy();
    unset($_SESSION['user']);
//    unset($_SESSION['userPermissions']);
//    unset($_SESSION['userAndRole']);
    unset($_SESSION['folder_name']);
header("location: ../index.php");