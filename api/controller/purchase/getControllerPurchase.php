<?php
require_once("../../model/DataBase.php");
$db = new DataBase(IDB::DB);
$type = $_GET['type'];
$responce = array(
    'success'=>false,
    'message'=>' Peticion equivocada ',
    'obj'=>array());
if( $type == 'autorization_list'){
    $purchase=array();
    $os = $_GET['subType'];
    $sql = "SELECT * FROM `purchase_order` WHERE ord_estatus = $os";
    $oc = $db->get($sql);
    if(count($oc)>0){

        for($i=0; $i<count($oc); $i++){
            $element = array(
                'cec_id'          => $oc[$i]['cec_id'],
                'emp_id'          => $oc[$i]['emp_id'],
                'ord_clave'       => $oc[$i]['ord_clave'],
                'ord_detalle'     => $oc[$i]['ord_detalle'],
                'ord_estatus'     => $oc[$i]['ord_estatus'],
                'ord_fecha'       => $oc[$i]['ord_fecha'],
                'ord_id'          => $oc[$i]['ord_id'],
                'ord_responsable' => $oc[$i]['ord_responsable'],
                'ord_proyecto'    => $oc[$i]['ord_proyecto'],
                'rup_id'          => $oc[$i]['rup_id'],
                'prv_id'          => $oc[$i]['prv_id'],
                'unicode'         => "OC".str_pad($oc[$i]['ord_id'], 5, '0', STR_PAD_LEFT).str_pad($oc[$i]['cec_id'], 3, '0', STR_PAD_LEFT),
                'factura'         => "FA".str_pad($oc[$i]['ord_id'], 5, '0', STR_PAD_LEFT).str_pad($oc[$i]['cec_id'], 3, '0', STR_PAD_LEFT)
            );
            $sql = "SELECT * FROM purchase_order_detail WHERE prd_ord_id = " . $oc[$i]['ord_id']  ;
            $doc = $db->get($sql);
            $detalle = array();
            $total = 0;
            $totalCantidad = 0;
            if(count($doc)>0){
                for($c=0; $c<count($doc); $c++ ){
                    $detalle[$c] = array(
                        'prd_ord_id'=>$doc[$c]['prd_ord_id'],
                        'prd_pro_descripcion'=>trim($doc[$c]['prd_pro_descripcion']),
                        'prd_cantidad'=>(int)$doc[$c]['prd_cantidad'],
                        'prd_uds_id'=>$doc[$c]['prd_uds_id'],
                        'prd_pro_precio_unitario'=>(float)$doc[$c]['prd_pro_precio_unitario'],
                    );
                    $total         += (int)$doc[$c]['prd_pro_precio_unitario'] * (int)$doc[$c]['prd_cantidad'];
                    $totalCantidad += (int)$doc[$c]['prd_cantidad'];
                }
                $purchase[$i]['cantidad_total'] = $totalCantidad;
                $purchase[$i]['total'] = $total ;
            }
            $purchase[$i]['purchase_order'] = array();
            $purchase[$i]['purchase_order_detail'] = $detalle;
            array_push($purchase[$i]['purchase_order'], $element);
            $element = array();
        }
    }
    $responce = array(
        'success'=>false,
        'message'=>' Ordenes de Compra Lista  ',
        'obj'=>$purchase);

}
echo json_encode( $responce );
