<?php
/**
 * Created by PhpStorm.
 * User: vijay
 * Date: 16-May-19
 * Time: 2:46 PM
 */

// TO SHOW ALERTS
 if (isset($_SESSION['msg']) && $_SESSION['msg'] ):
        alert($_SESSION['msg'], $_SESSION['msg_color']);;
            unset($_SESSION['msg']);
            $_SESSION['msg'] = FALSE;
 endif;

if (isset($_SESSION['msg_array']) && $_SESSION['msg_array']){

    foreach ($_SESSION['msg_array'] as $msg) {
        alert($msg, $_SESSION['msg_array_color']);;
    }
    unset($_SESSION['msg_array']);
    unset($_SESSION['msg_array_color']);
    $_SESSION['msg_array'] = FALSE;

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




