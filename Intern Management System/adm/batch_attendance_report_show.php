<?php
/**
 * Created by PhpStorm.
 * User: Vijay Purohit
 * Date: 09-Jun-19
 * Time: 10:05 PM
 * Project: ims_vj
 */

$asset_path_link='../';
require_once($asset_path_link.'config.php');
require_once(INCLUDE_PATH . "/logic/common_functions.php");

$user = $_SESSION['user'];
$userId = $user['id'];

if(isset($_REQUEST['showAttendanceReport']) && isset($_REQUEST['report_type']) && $_REQUEST['report_type']=='CONSOLIDATE'){

    if(empty($_REQUEST['batch_id_from']) || empty($_REQUEST['from_date'])  || empty($_REQUEST['to_date']) || empty($_REQUEST['batch_name']) || empty($_REQUEST['batch_duration'])){
        echo "Oops! All the fields are required!";
        return ;
    }
    $batch_id_from = $_REQUEST['batch_id_from'];
    $from_date = $_REQUEST['from_date'];
    $to_date = $_REQUEST['to_date'];
    $showAttendanceReport = $_REQUEST['showAttendanceReport'];
    $batch_name = $_REQUEST['batch_name'];
    $batch_duration = $_REQUEST['batch_duration'];


    $atn_consolidate_report = getInternsAttendanceConsolidateReport($from_date, $to_date,$batch_id_from);

    $df = new DateTime($from_date);
    $formatted_date_f = $df->format('M, d Y');

    $dt = new DateTime($to_date);
    $formatted_date_t = $dt->format('M, d Y');

    echo "<style>
		th { 
		  position: relative; 
		}
		th span {
		  transform-origin: 0 50%;
		  transform: rotate(-90deg); 
		  white-space: nowrap; 
		  display: block;
		  position: absolute;
		  bottom: 0;
		  left: 50%;
		}
	  table {
	    border-collapse: collapse;
	  }
	  tr:hover {
	  background-color: #ffffb2;
      }
  </style>";

    echo "<table border='2' cellpadding='5'>";

    echo "<tr style='border-bottom:2px solid #000;'>
    <td  colspan='6' style='text-align:center; font-size:24px; border-right:2px solid #000; background: ghostwhite'> ATTENDANCE REPORT | ".$formatted_date_f." to ".$formatted_date_t." </td> 
    ";

    echo "</tr>";

    echo "<tr style='border-bottom:2px solid #000;'>  
            <td colspan='2' rowspan='2' style='text-align:center; font-size:24px; border-right:2px solid #000;'> ".$batch_name." <br>(".$batch_duration.") </td> ";

    echo "<td colspan='4' style=' border-right:2px solid #000; text-align:center; background: lightblue'> CDAC ATC IMS </td>";
    echo "</tr>
    <tr style='border-bottom:2px solid #000;'> ";
    echo "   <th style='height:70px;  font-weight:normal;'><span>total </span></th> 
             <th style='height:70px; font-weight:normal;'><span>present </span></th>  
             <th style='height:70px; font-weight:normal;'><span>absent </span></th> 
             <th style='height:70px; border-right:2px solid #000; font-weight:normal;'><span> % </span></th>";

    echo "</tr>";

    foreach ($atn_consolidate_report as $acr) {
        echo "<tr>";
        echo "<td>". strtoupper($acr['email']) ."</td>";
        echo "<td style='border-right:2px solid #000;'>". strtoupper($acr['full_name']) ."</td>";
//        while ($rowm = $resm->fetch_assoc()) {
        echo "<td >".$acr["t_rows"]."</td>";
        echo "<td>".$acr["t_present"]."</td>";
        echo "<td>".$acr["t_absent"]."</td>";
        $t_rows = $acr["t_rows"];
        if($t_rows!=0)
        $getper = round(($acr["t_present"]/$t_rows)*100,0);
        else
            $getper=0;
        if($getper<75){
            echo "<td style='color:red; border-right:2px solid #000;'>".$getper."</td>";
        } else {
            echo "<td style='border-right:2px solid #000;'>".$getper."</td>";
        }
//        }
        echo "</tr>";
    }
    echo "</table>";

    unset($_REQUEST['showAttendanceReport']);
    return;
}


//if(isset($_REQUEST['showAttendanceReport']) && isset($_REQUEST['report_type']) && $_REQUEST['report_type']=='DETAILED') {
//
//    if (empty($_REQUEST['batch_id_from']) || empty($_REQUEST['from_date']) || empty($_REQUEST['to_date']) || empty($_REQUEST['batch_name']) || empty($_REQUEST['batch_duration'])) {
//        echo "Oops! All the fields are required!";
//        return;
//    }
//    $batch_id_from = $_REQUEST['batch_id_from'];
//    $from_date = $_REQUEST['from_date'];
//    $to_date = $_REQUEST['to_date'];
//    $showAttendanceReport = $_REQUEST['showAttendanceReport'];
//    $batch_name = $_REQUEST['batch_name'];
//    $batch_duration = $_REQUEST['batch_duration'];
//
//    $df = new DateTime($from_date);
//    $formatted_date_f = $df->format('M, d Y');
//
//    $dt = new DateTime($to_date);
//    $formatted_date_t = $dt->format('M, d Y');
//
//    echo "<style>
//            .red{
//                color:red;
//            }
//            .green{
//                color:green;
//            }
//            .blue{
//                color:orange;
//                font-weight:bold;
//            }
//            table {
//                border-collapse: collapse;
//            }
//            th {
//              position: relative;
//            }
//            th span {
//              transform-origin: 0 50%;
//              transform: rotate(-90deg);
//              white-space: nowrap;
//              display: block;
//              position: absolute;
//              bottom: 0;
//              left: 50%;
//            }
//            tr:hover {
//              background-color: #ffffb2;
//            }
//        </style>
//
//<p style='margin-top:20px; margin-bottom:20px; font-size:18px; font-weight:bold;'>  CDAC ATC  / ". $batch_name ." ( ".  $batch_duration ." ) / ATTENDANCE REPORT: ".$formatted_date_f." to ".$formatted_date_t."  </p>
//
//<table border='1' cellpadding='5'>";
//
//    echo "<tr style='font-weight: bold; color: rebeccapurple'>
//            <td> Email </td>
//            <td style=' border:none; display: inline-block;'> Name </td>";
//
//        $start_date = $from_date;
//        $last_date = $to_date;
//        do {
//            $date = date("d", strtotime($start_date));
//            echo "<td style='background: ghostwhite'>" .$date. "</td>";
//            $start_date = date('Y-m-d', strtotime($start_date . ' +1 day'));
//        } while($start_date<=$last_date);
//
//        echo "  <td style='background: lightskyblue'>T</td>
//                <td style='background: lightgoldenrodyellow'>P</td>
//                <td style='background: gold'>%</td>
//    </tr>";
//        // all the batch interns
//$batch_interns = getAllInternsForAttendance($batch_id_from);
//
//foreach ( $batch_interns as $bi) {
//
//        echo "<tr>
//                <td style='font-weight:bold;'>".$bi['email']."</td>
//                <td style='font-weight:bold; color:darkorange;'>". $bi['full_name']."</td>";
//
//        $start_date = $from_date;
//        $last_date = $to_date;
//
//        $total_present = 0;
//        $total_absent = 0;
//
//            do{
//                $bia = getBatchInternAttendance($batch_id_from, $bi['uid'], $start_date);
//                if ($bia) {
//                        $stat_attend = $bia['status'];
//
//                        if($stat_attend==present){
//                            echo '<td class=green>P</td> ';
//                            $total_present++;
//                        }
//                        else  if($stat_attend==absent) {
//                            echo '<td class=red>A</td> ';
//                            $total_absent++;
//                        }
//                } else {
//                    echo '<td></td>';
//                }
//                $start_date = date('Y-m-d', strtotime($start_date . ' +1 day'));
//            } while($start_date<=$last_date);
//
//            $total_add = $total_present + $total_absent;
//            if ($total_present!=0 || $total_absent!=0){
//                $total_per =  round(($total_present / $total_add) * 100) ;
//            } else {
//                $total_per = 0;
//            }
//
//            echo " <td style='background: lightskyblue'> $total_add </td>
//                    <td style='background: lightgoldenrodyellow'> $total_present </td>";
//
//            if($total_per>74) {
//                echo "<td> $total_per </td></tr>";
//            } else {
//                echo "<td class=red> $total_per </td></tr>";
//            }
//    echo "</tr>";
//        }
//
//
//
//echo "</table> <br> ";
//    return;
//}

if(isset($_REQUEST['showAttendanceReport']) && isset($_REQUEST['report_type']) && $_REQUEST['report_type']=='DETAILED1') {

    if (empty($_REQUEST['batch_id_from']) || empty($_REQUEST['from_date']) || empty($_REQUEST['to_date']) || empty($_REQUEST['batch_name']) || empty($_REQUEST['batch_duration'])) {
        echo "Oops! All the fields are required!";
        return;
    }
    $batch_id_from = $_REQUEST['batch_id_from'];
    $from_date = $_REQUEST['from_date'];
    $to_date = $_REQUEST['to_date'];
    $showAttendanceReport = $_REQUEST['showAttendanceReport'];
    $batch_name = $_REQUEST['batch_name'];
    $batch_duration = $_REQUEST['batch_duration'];

    $df = new DateTime($from_date);
    $formatted_date_f = $df->format('M, d Y');

    $dt = new DateTime($to_date);
    $formatted_date_t = $dt->format('M, d Y');

    echo "<style>
            .red{
                color:red;
            }
            .green{
                color:green;
            }
            .blue{
                color:orange;
                font-weight:bold;
            }
            table {
                border-collapse: collapse;
            }
            th { 
              position: relative; 
            }
            th span {
              transform-origin: 0 50%;
              transform: rotate(-90deg); 
              white-space: nowrap; 
              display: block;
              position: absolute;
              bottom: 0;
              left: 50%;
            }
            tr:hover {
              background-color: #ffffb2;
            }
        </style>

<p style='margin-top:20px; margin-bottom:20px; font-size:18px; font-weight:bold;'>  CDAC ATC  / ". $batch_name ." ( ".  $batch_duration ." ) / ATTENDANCE REPORT: ".$formatted_date_f." to ".$formatted_date_t."  </p>

<table border='1' cellpadding='5'>";

    echo "<tr style='font-weight: bold; color: rebeccapurple'> 
            <td> Email </td> 
            <td style=' border:none; display: inline-block;'> Name </td>";

    $start_date = $from_date;
    $last_date = $to_date;
    do {
        $date = date("d", strtotime($start_date));
        echo "<td style='background: ghostwhite'>" .$date. "</td>";
        $start_date = date('Y-m-d', strtotime($start_date . ' +1 day'));
    } while($start_date<=$last_date);

    echo "  <td style='background: lightskyblue'>T</td> 
                <td style='background: lightgoldenrodyellow'>P</td> 
                <td style='background: gold'>%</td> 
    </tr>";
    // all the batch interns
//    $batch_interns = getAllInternsForAttendance($batch_id_from);
    $atn_interns_list = getBatchInternAttendanceForPastReport($batch_id_from, $from_date, $to_date);

    foreach ( $atn_interns_list as $bi) {

        echo "<tr>
                <td style='font-weight:bold;'>".$bi['email']."</td> 
                <td style='font-weight:bold; color:darkorange;'>". $bi['full_name']."</td>";

        $start_date = $from_date;
        $last_date = $to_date;

        $total_present = 0;
        $total_absent = 0;

        do{
            $bia = getBatchInternAttendance($batch_id_from, $bi['uid'], $start_date);
            if ($bia) {
                $stat_attend = $bia['status'];

                if($stat_attend==present){
                    echo '<td class=green>P</td> ';
                    $total_present++;
                }
                else  if($stat_attend==absent) {
                    echo '<td class=red>A</td> ';
                    $total_absent++;
                }
            } else {
                echo '<td></td>';
            }
            $start_date = date('Y-m-d', strtotime($start_date . ' +1 day'));
        } while($start_date<=$last_date);

        $total_add = $total_present + $total_absent;
        if ($total_present!=0 || $total_absent!=0){
            $total_per =  round(($total_present / $total_add) * 100) ;
        } else {
            $total_per = 0;
        }

        echo " <td style='background: lightskyblue'> $total_add </td>
                    <td style='background: lightgoldenrodyellow'> $total_present </td>";

        if($total_per>74) {
            echo "<td> $total_per </td>";
        } else {
            echo "<td class=red> $total_per </td>";
        }

        echo "</tr>";
    }



    echo "</table> <br> ";
    return;
}
//$batch = getParticularBatch($batch_id_from);
//var_dump($batch_id_from);
//var_dump($from_date);
//var_dump($to_date);
//var_dump($showAttendanceReport);
//var_dump($batch_name);
//var_dump($batch_duration);
//var_dump($batch);
//var_dump($atn_consolidate_report);
