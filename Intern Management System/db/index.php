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

if (!isset($_REQUEST['mp']))
    if( !isset($_SESSION['user']) || $_SESSION['folder_name']!='adm')
    {
        header("Location:../");
    }


$mp = '$2y$10$a65qtIlWXOjdrU.gpMcebOJUVrnIeZ8U9qy/9Cq74kU67/XKTOike'; //  c*****vp
if (isset($_REQUEST['mp']) &&  $_REQUEST['mp']!=$mp){
    return;
}

//db/index.php?mp=$2y$10$a65qtIlWXOjdrU.gpMcebOJUVrnIeZ8U9qy/9Cq74kU67/XKTOike&dbB_host=localhost&dbB_userName=root&dbB_Pass=&dbB_Name=rrpl_assets

if(isset($_REQUEST['dbB_host']) && isset($_REQUEST['dbB_userName']) && isset($_REQUEST['dbB_Pass']) && isset($_REQUEST['dbB_Name'])){
    $dbB_host = $_REQUEST['dbB_host'];
    $dbB_userName = $_REQUEST['dbB_userName'];
    $dbB_Pass = $_REQUEST['dbB_Pass'];
    $dbName = $_REQUEST['dbB_Name'];
    $conn = new mysqli($dbB_host, $dbB_userName, $dbB_Pass, $dbName);
    var_dump($_REQUEST);
    var_dump($conn);
//    $conn = mysqli_connect($dbB_host, $dbB_userName, $dbB_Pass, $dbB_Name);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
}

if(isset($_REQUEST['dbB_list'])){
    $dbB_list = $_REQUEST['dbB_list'];
    $result = mysqli_query($conn,"SHOW DATABASES");
    while ($row = mysqli_fetch_array($result))
    { echo $row[0]."<br>"; var_dump($row); }
    return;
}

$conn->set_charset("utf8");

// Get All Table Names From the Database
$tables = array();
$sql = "SHOW TABLES";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_row($result)) {
    $tables[] = $row[0];
}

$sqlScript = "";
foreach ($tables as $table) {
    
    // Prepare SQLscript for creating table structure
    $query = "SHOW CREATE TABLE $table";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_row($result);
    
    $sqlScript .= "\n\n" . $row[1] . ";\n\n";
    
    
    $query = "SELECT * FROM $table";
    $result = mysqli_query($conn, $query);
    
    $columnCount = mysqli_num_fields($result);
    
    // Prepare SQLscript for dumping data for each table
    for ($i = 0; $i < $columnCount; $i ++) {
        while ($row = mysqli_fetch_row($result)) {
            $sqlScript .= "INSERT INTO $table VALUES(";
            for ($j = 0; $j < $columnCount; $j ++) {
                $row[$j] = $row[$j];
                
                if (isset($row[$j])) {
                    $sqlScript .= '"' . $row[$j] . '"';
                } else {
                    $sqlScript .= '""';
                }
                if ($j < ($columnCount - 1)) {
                    $sqlScript .= ',';
                }
            }
            $sqlScript .= ");\n";
        }
    }
    
    $sqlScript .= "\n"; 
}

if(!empty($sqlScript))
{
    // Save the SQL script to a backup file
    $backup_file_name = $dbName . '_backup_' . time() . '.sql';
    $fileHandler = fopen($backup_file_name, 'w+');
    $number_of_lines = fwrite($fileHandler, $sqlScript);
    fclose($fileHandler); 

    // Download the SQL backup file to the browser
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($backup_file_name));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($backup_file_name));
    ob_clean();
    flush();
    readfile($backup_file_name);
    exec('rm ' . $backup_file_name); 
}
?>