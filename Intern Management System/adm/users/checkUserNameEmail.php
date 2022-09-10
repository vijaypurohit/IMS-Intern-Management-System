<?php
/**
 * Created by PhpStorm.
 * User: Vijay Purohit
 * Date: 5/23/2019
 * Time: 1:03 PM
 * Project: ims_vj
 */


include('../../includes/layouts/_connect.php');
//echo "true";
if (isset($_REQUEST['username'])) {
    global $conn;
    $username = $_REQUEST['username'];
//    $username = mysqli_real_escape_string($n);
    $sql = "SELECT username FROM users WHERE username='$username'";
    $resultSet = mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    if ($row) {
        echo "false";
    } else {

        echo "true";
       //No Record Found - Username is available
    }
}
exit;
