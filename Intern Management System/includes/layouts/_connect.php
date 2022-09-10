<?php
/**
 * Created by PhpStorm.
 * User: vijay
 * Date: 17-May-19
 * Time: 11:47 AM
 */

// TO CONNECT WITH DATABASE

$serverName = "localhost";
$dbName = "ims_cdac_vj";
$dbUserName = "root";
$dbPass = "";
//define("serverName", "localhost");
//define("dbName", "ims_cdac_vj");
//define("dbUserName", "root");
//define("dbPass", "");
// connect to database Mysqli syntax
    $conn = new mysqli($serverName, $dbUserName, $dbPass, $dbName);
    // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

// connect to database PDO syntax
    $dsn = "mysql:host=$serverName;dbname=$dbName;charset=utf8mb4";
        $options = [
            PDO::ATTR_EMULATE_PREPARES   => false,                      // turn off emulation mode for "real" prepared statements
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       //make the default fetch be an associative array
        ];
    try {
        $pdo_conn = new PDO($dsn, $dbUserName, $dbPass, $options);
    } catch (Exception $e) {
        error_log($e->getMessage());
        exit('Something weird happened with database'); //something a user can understand
    }

//public function connectMySQLi($serverName, $dbUserName, $dbPass, $dbName) {
//    // connect to database Mysqli syntax
//    $conn = new mysqli($serverName, $dbUserName, $dbPass, $dbName);
//
//    if ( $conn->connect_error) {
//        die("Connection failed: " .  $conn->connect_error);
//    }
//    else
//        return $conn;
//
//}
//
//public function connectPDO($serverName, $dbUserName, $dbPass, $dbName){
//    // connect to database PDO syntax
//    $dsn = "mysql:host=$serverName;dbname=$dbName;charset=utf8mb4";
//    $options = [
//        PDO::ATTR_EMULATE_PREPARES => false,                      // turn off emulation mode for "real" prepared statements
//        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,        //turn on errors in the form of exceptions
//        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       //make the default fetch be an associative array
//    ];
//
//    try {
//        $pdo_conn = new PDO($dsn, $dbUserName, $dbPass, $options);
//    } catch (Exception $e) {
//        error_log($e->getMessage());
//        exit('Something weird happened with database'); //something a user can understand
//    }
//    return $pdo_conn;
//}