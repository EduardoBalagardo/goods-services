<?php
session_start();
if (isset($_SESSION["uid"])) {
    echo json_encode(array('success'=>true,
                           'message'=>'autentified',
                           'session'=>$_SESSION['uid']));
} else {
    echo json_encode(array(
        'success'=>false,
        'message'=>'not_autentified',
        'session'=>'xxxxputonmijon'));
}
