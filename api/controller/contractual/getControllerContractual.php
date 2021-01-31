<?php
require_once("../../model/DataBase.php");
$db = new DataBase(IDB::DB);
$type = $_GET['type'];
$subtype = (isset($_GET['subType'])  ? $_GET['subType'] : '') ;
$responce = array( 'success'=>false,'message'=>' Peticion equivocada ','obj'=>array()  );
if ($type == 'contractual_order') {
    $ordcontractual = array();
    $sql = "SELECT * FROM purchase_order_contractual
            INNER JOIN cat_proveedores ON cat_proveedores.prv_id = purchase_order_contractual.orc_prv_id
            WHERE orc_estatus = 1";
    $oc = $db->get($sql);
    if (count($oc)>0) {
        for ($i=0; $i<count($oc); $i++) {

          $element = array(
          'orc_id'            => $oc[$i]['orc_id'],
          'orc_nit'           => $oc[$i]['orc_nit'],
          'orc_factura'       => $oc[$i]['orc_factura'],
          'oc'                => 'OC'.substr( $oc[$i]['orc_factura'] , 2 , strlen($oc[$i]['orc_factura']) ),
          'orc_prv_id'        => $oc[$i]['orc_prv_id'],
          'prv_nombre'        => utf8_decode($oc[$i]['prv_nombre']),
          'prv_giro'          => utf8_decode($oc[$i]['prv_giro']),
          'ord_emp_id'        => $oc[$i]['ord_emp_id'],
          'orc_fecha_order'   => $oc[$i]['orc_fecha_order'],
          'orc_fecha_entrega' => $oc[$i]['orc_fecha_entrega'],
          'orc_monto_total'   => $oc[$i]['orc_monto_total'],
          'orc_estatus'       => $oc[$i]['orc_estatus'],
          );
            $sql = "SELECT * FROM purchase_order_contractual_detail
                    WHERE ocd_orc_id = {$oc[$i]['orc_id']} ";
            $doc = $db->get($sql);
            $detalle = array();
            if (count($doc)>0) {
                for ($c=0; $c<count($doc); $c++) {

                      $detalle[$c] = array( 'ocd_id'=>$doc[$c]['ocd_id'],
                      'ocd_orc_id'=>$doc[$c]['ocd_orc_id'],
                      'ocd_pro_id'=>$doc[$c]['ocd_pro_id'],
                      'ocd_descripcion'=>$doc[$c]['ocd_descripcion'],
                      'ocd_cantidad'=>$doc[$c]['ocd_cantidad'],
                      'ocd_total'=>$doc[$c]['ocd_total'],
                      'ocd_estatus'=>$doc[$c]['ocd_estatus']);
                }
            }
            $ordcontractual[$i]['purchase_contractual'] = $element;
            $ordcontractual[$i]['purchase_contractual_detail'] = $detalle;
            $element = array();
        }
    }
    $responce = array( 'success'=>true,'message'=>' Ordenes Contraatuales ','obj'=>$ordcontractual  );
}

echo json_encode($responce);
