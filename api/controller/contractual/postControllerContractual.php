<?php
require_once("../../model/DataBase.php");
require_once '../../model/libraries/fpdf17/fpdf.php';
require_once '../../model/libraries/EnLetras.php';
$db = new DataBase(IDB::DB);
$user = array();
$responce = array('success'=>false, 'message'=>"Bad Request", 'obj'=>array());
$_POST = json_decode(file_get_contents('php://input'), true);
if (isset($_POST['cOrdDetail'])) {
    if (count($_POST['cOrdDetail'])>0) {
        for ($i=0; $i<count($_POST['cOrdDetail']); $i++) {
            $sql = "SELECT * FROM purchase_order_contractual WHERE orc_id = {$_POST['cOrdDetail'][$i]}";
            $oct = $db->get($sql);
            if(count($oct)>0){
              for($c=0; $c<count($oct); $c++){
                ///INSERCION NEW ENTRIES
                $date =  date("Y-m-d h:i:s");
                $sql = "INSERT INTO entries_storages( ent_fecha, ent_factura, ent_prv_id, ent_cantidad, ent_total, ent_estatus) VALUES ('$date','{$oct[$c]['orc_factura']}',{$oct[$c]['orc_prv_id']},{$oct[$c]['orc_cantidad_total']},{$oct[$c]['orc_monto_total']},1) ";
                if( $db->put($sql) == true ){
                  ///UPDATE ORDER CONTRACTUAL
                  $sql = "UPDATE purchase_order_contractual SET orc_fecha_entrega = '{$date}', orc_estatus = 2 WHERE orc_id = {$_POST['cOrdDetail'][$i]} ";
                  if($db->put($sql)== true){
                    //SELECT DETAILED ENTRIES
                    $sql = "SELECT * FROM purchase_order_contractual_detail WHERE ocd_orc_id = {$_POST['cOrdDetail'][$i]}";
                    $ocd = $db->get($sql);
                    $values = "";
                    $ids    = "";
                    if(count($ocd)>0){
                      for( $o=0; $o<count($ocd); $o++ ){
                        $values .=  ($o == count($ocd)-1) ? "({$_POST['cOrdDetail'][$i]} ,{$ocd[$o]['ocd_pro_id']},'{$ocd[$o]['ocd_descripcion']}',1,{$ocd[$o]['ocd_cantidad']})" : "({$_POST['cOrdDetail'][$i]} ,{$ocd[$o]['ocd_pro_id']},'{$ocd[$o]['ocd_descripcion']}',1,{$ocd[$o]['ocd_cantidad']}),";
                        $ids    .=  ($o == count($ocd)-1) ? "{$ocd[$o]['ocd_id']}" : "{$ocd[$o]['ocd_id']}," ;
                      }
                      //INSERT ENTRIES DETAILED
                      $sql = "INSERT INTO entries_storages_detail(end_ent_id, end_pro_id, end_nombre_bien, end_estatus, end_stock) VALUES " . $values;
                      if($db->put($sql)== true){
                        $sql = "UPDATE purchase_order_contractual_detail  SET ocd_estatus = 1 WHERE ocd_id IN ($ids)";
                        if($db->put($sql)==true){
                          //CREAR ARCHIVO DE FACTURA SELLADO DE RECIBIDO.
                        }
                      }
                    }
                  }
                }
              }
            }
        }
        $responce = array('success'=>true, 'message'=>" Retrivering File Created and Update Fields In DB ", 'obj'=>$_POST['cOrdDetail']);
    } else {
        $responce = array('success'=>false, 'message'=>" No existen Datos Revisados ", 'obj'=>$_POST['cOrdDetail']);
    }
}
echo json_encode($responce);
