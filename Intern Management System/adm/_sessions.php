<?php
/**
 * Created by PhpStorm.
 * User: Vijay Purohit
 * Date: 5/21/2019
 * Time: 12:51 PM
 * Project: ims_vj
 */

// SIDEBAR AFTER MY PROFILE
// SESSION

//session_start();
if( !isset($_SESSION['user']) || $_SESSION['folder_name']!='adm')
{
    header("Location:../");
}

//if(isset($_SESSION['user']) && $_SESSION['folder_name']=='adm')
//{
//    header("Location: " . $_SESSION['folder_name'] . "");
//}