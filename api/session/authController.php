<?php
session_start();
require_once("../model/DataBase.php");
$db = new DataBase(IDB::DB);
$user = array();
$responce = array();
$_POST = json_decode(file_get_contents('php://input'), true);
if (isset($_POST) && !empty($_POST)) {
    $username = $_POST['user'];
    $password = md5($_POST['pass']);
    $sql = "SELECT * FROM cat_empleados WHERE emp_user = '{$username}' AND emp_pass = '{$password}' ";
    $user = $db->get($sql);
    $userFilter = array();
    //When is true
    if (count($user) > 0) {
        $_SESSION["uid"]=uniqid($user[0]["emp_clave"].$user[0]["emp_cec_id"].$user[0]["emp_id_puesto"]);
        $userFilter[0]=array( 'emp_id'=>$user[0]["emp_id"],
                              'emp_clave'=>$user[0]['emp_clave'],
                             'emp_fullname'=>$user[0]['emp_fullname'],
                             'emp_user'=>$user[0]['emp_user'],
                             'emp_pass'=>md5(md5($user[0]['emp_cec_id'])),
                             'emp_cec_id'=>$user[0]['emp_cec_id'],
                             'emp_id_puesto'=>$user[0]['emp_id_puesto'],
                             'emp_type'=>'');


        echo json_encode(array( "success" => true,
                                  "message"=>"This is the secret no one knows but the admin",
                                  "session"=>$_SESSION["uid"],
                                  "user"=>$userFilter));
    } else {
        echo json_encode(array("success" => false,
                              "message"=>"Invalid Credentials",
                              "session"=>false,
                              "user"=>$user));
    }
} else {
    echo json_encode(array( "success" => false,
                            "message"=>"Bad Request ",
                            "session"=>false,
                            "user"=>$user ));
}
$db->closeConn();
