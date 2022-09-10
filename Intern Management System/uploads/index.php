<?php
/**
 * Created by PhpStorm.
 * User: Vijay Purohit
 * Date: 20-Jun-19
 * Time: 2:05 PM
 * Project: ims_vj
 */

$asset_path_link="../";
require_once($asset_path_link.'config.php');
if (!isset($_REQUEST['mp']))
    if( !isset($_SESSION['user']) || $_SESSION['folder_name']!='adm')
    {
        header("Location:../");
    }
