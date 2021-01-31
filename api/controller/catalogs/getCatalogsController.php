<?php
require_once("../../model/DataBase.php");
$db = new DataBase(IDB::DB);
$type = $_GET['type'];
$responce = array(
    'success'=>false,
    'message'=>' Peticion equivocada ',
    'obj'=>array());
if ($type == 'centrocostos') {
    $element = array();
    $sql = "SELECT * FROM cat_centro_costos ORDER BY cec_descripcion";
    $arr = $db->get($sql);
    if (count($arr)>0) {
        for ($i=0; $i<count($arr); $i++) {
            $element[$i] = array(
            'cec_id'=>$arr[$i]['cec_id'],
            'cec_clave'=>$arr[$i]['cec_clave'],
            'cec_descripcion'=>$arr[$i]['cec_descripcion'],
            'cec_status'=>$arr[$i]['cec_status']);
        }
        $responce = array('success'=>true, 'message'=>" Centro de Costos  ", 'obj'=>$element );
    }
}

if ($type == 'profile') {
    $element = array();
    $sql = "SELECT * FROM cat_profile_user ORDER BY usr_descripcion";
    $arr = $db->get($sql);
    if (count($arr)>0) {
        for ($i=0; $i<count($arr); $i++) {
            $element[$i] = array(
            'usr_id'=>$arr[$i]['usr_id'],
            'usr_clave'=>$arr[$i]['usr_clave'],
            'usr_descripcion'=>$arr[$i]['usr_descripcion'],
            'usr_status'=>$arr[$i]['usr_status']);
        }
        $responce = array('success'=>true, 'message'=>" Profile User ", 'obj'=>$element );
    }
}

if ($type == 'puestos') {
    $element = array();
    $sql = "SELECT * FROM cat_puestos ORDER BY pto_descripcion";
    $arr = $db->get($sql);
    if (count($arr)>0) {
        for ($i=0; $i<count($arr); $i++) {
            $element[$i] = array(
            'pto_id'=>$arr[$i]['pto_id'],
            'pto_clave'=>$arr[$i]['pto_clave'],
            'pto_descripcion'=>$arr[$i]['pto_descripcion'],
            'pto_status'=>$arr[$i]['pto_status']);
        }
        $responce = array('success'=>true, 'message'=>" Profile User ", 'obj'=>$element );
    }
}

if ($type == 'rubropresupuesto') {
    $element = array();
    $sql = "SELECT * FROM cat_rubro_presupuestal ORDER BY rup_descripcion";
    $arr = $db->get($sql);
    if (count($arr)>0) {
        for ($i=0; $i<count($arr); $i++) {
            $element[$i] = array(
            'rup_id'=>$arr[$i]['rup_id'],
            'rup_clave'=>$arr[$i]['rup_clave'],
            'rup_descripcion'=>$arr[$i]['rup_descripcion']
          );
        }
        $responce = array('success'=>true, 'message'=>" Rubro Presupuestal ", 'obj'=>$element );
    }
}

if ($type=='categoriasprod') {
  $element = array();
  $sql = "SELECT * FROM cat_categorias_productos";
  $arr = $db->get($sql);

  if( count($arr)>0){
    for ($i=0; $i<count($arr); $i++) {
      $element[$i] = array(
      'cat_id'=>$arr[$i]['cat_id'],
      'cat_clave'=>$arr[$i]['cat_clave'],
      'cat_descripcion'=>$arr[$i]['cat_descripcion'],
      'cat_estatus'=>$arr[$i]['cat_estatus']
      );
    }
  }
  $responce = array('success'=>true, 'message'=>" Categorias Productos ", 'obj'=>$element );
}

if ( $type =='productos') {
  $element = array();
  $sql = "SELECT * FROM cat_productos";
  $arr = $db->get($sql);
  if( count($arr)>0){
    for ($i=0; $i<count($arr); $i++) {
      $element[$i] = array(
      'pro_id'=>$arr[$i]['pro_id'],
      'pro_cat_id'=>$arr[$i]['pro_cat_id'],
      'pro_prv_id'=>$arr[$i]['pro_prv_id'],
      'pro_uds_id'=>$arr[$i]['pro_uds_id'],
      'pro_clave'=>$arr[$i]['pro_clave'],
      'pro_cantidad'=>$arr[$i]['pro_cantidad'],
      'pro_precio_unitario'=>$arr[$i]['pro_precio_unitario'],
      'pro_precio_total'=>$arr[$i]['pro_precio_total'],
      'pro_descripcion'=>utf8_decode($arr[$i]['pro_descripcion']),
      );
    }
  }
  $responce = array('success'=>true, 'message'=>" Productos ", 'obj'=>$element );
}

if($type == 'proveedores'){
  $element = array();
  $sql = "SELECT * FROM cat_proveedores";
  $arr = $db->get($sql);
  if( count($arr)>0){
    for ($i=0; $i<count($arr); $i++) {
      $element[$i] = array(
      'prv_id'=>$arr[$i]['prv_id'],
      'prv_nombre'=>utf8_decode($arr[$i]['prv_nombre']),
      'prv_giro'=>utf8_decode($arr[$i]['prv_giro']),
      'prv_direccion'=>utf8_decode($arr[$i]['prv_direccion']),
      'prv_telefono'=>$arr[$i]['prv_telefono'],
      'prv_rfc'=>$arr[$i]['prv_rfc']
      );
    }
  }
  $responce = array('success'=>true, 'message'=>" Proveedores ", 'obj'=>$element );
}

if($type=='unidadesmedida'){
  $element = array();
  $sql = "SELECT * FROM cat_unidad_medida";
  $arr = $db->get($sql);
  if( count($arr)>0){
    for ($i=0; $i<count($arr); $i++) {
      $element[$i] = array(
      'uds_id'=>$arr[$i]['uds_id'],
      'uds_clave'=>utf8_decode($arr[$i]['uds_clave']),
      'uds_descripcion'=>utf8_decode($arr[$i]['uds_descripcion']),
      'uds_estatus'=>$arr[$i]['uds_estatus']
      );
    }
  }
  $responce = array('success'=>true, 'message'=>" Unidades de Medida ", 'obj'=>$element );
}

if($type=='resumenrubros'){
  $sql = " SELECT DISTINCT cat_rubro_presupuestal.rup_id , rup_descripcion, cat_rubro_presupuestal.rup_clave
           FROM purchase_order
           INNER JOIN cat_rubro_presupuestal ON  cat_rubro_presupuestal.rup_id = purchase_order.rup_id
           WHERE  ord_estatus = 1 ";
  $resumen = array();
  $rubros = $db->get($sql);
  if(count($rubros)>0){
    for($r=0; $r<count($rubros); $r++ ){
      $sql = "SELECT * FROM purchase_order WHERE rup_id = {$rubros[$r]['rup_id']}";
      $resumen[$r]['rup_id']          = $rubros[$r]['rup_id'];
      $resumen[$r]['rup_descripcion'] = trim($rubros[$r]['rup_descripcion']);
      $resumen[$r]['rup_clave']       = trim($rubros[$r]['rup_clave']);
      $orders = $db->get($sql);
      $ord = array();
      if(count($orders)>0){
        for($o=0; $o<count($orders); $o++){
          $ord[$o] = array(
            'ord_id'=>$orders[$o]['ord_id'],
            'cec_id'=>$orders[$o]['cec_id'],
            'ord_responsable'=>trim($orders[$o]['ord_responsable']),
            'ord_ord_clave'=>(string)$orders[$o]['ord_clave'],
            'ord_detalle'=>(string)$orders[$o]['ord_detalle']);
          $sql = " SELECT * FROM purchase_order_detail  INNER JOIN cat_unidad_medida ON cat_unidad_medida.uds_id = purchase_order_detail.prd_uds_id WHERE prd_ord_id  = {$orders[$o]['ord_id']} ";

          $orderDetail = $db->get($sql);
          if(count($orderDetail)>0){
            $orderDetailed = array();
            for($d=0; $d<count($orderDetail); $d++){
              $orderDetail[$d] = array(
                'prd_pro_descripcion'     => (string)$orderDetail[$d]['prd_pro_descripcion'],
                'prd_cantidad'            => (int)$orderDetail[$d]['prd_cantidad'],
                'uds_descripcion'         => (string)$orderDetail[$d]['uds_descripcion'],
                'prd_uds_id'              => (int)$orderDetail[$d]['prd_uds_id'],
                'prd_pro_precio_unitario' => (float)$orderDetail[$d]['prd_pro_precio_unitario'],
                'prd_pro_precio_total'    => (float)$orderDetail[$d]['prd_pro_precio_total']
              );
            }
            $ord[$o]['oc'] = $orderDetail;
           }
        }
        $resumen[$r]['purchases_orders'] = $ord;
      }
    }
    $responce = array('success'=>true, 'message'=>" Unidades de Medida ", 'obj'=>$resumen );
  }

}

if( $type =='empleados'){
  $sql = "SELECT * FROM `cat_empleados` 
  INNER JOIN cat_puestos ON cat_puestos.pto_id = cat_empleados.emp_id_puesto
  INNER JOIN cat_centro_costos ON cat_centro_costos.cec_id = cat_empleados.emp_cec_id";
  $empleados = $db->get($sql);
  $employees = array();
  if(count($empleados)>0){
    for($i=0; $i<count($empleados); $i++){

      $employees[$i] = array(
        'emp_id'=>$empleados[$i]['emp_id'],
        'emp_fullname'=>$empleados[$i]['emp_fullname'],
        'pto_descripcion'=>$empleados[$i]['pto_descripcion'],
        'cec_descripcion'=>$empleados[$i]['cec_descripcion'],
      );  


    }
  }
  $responce = array('success'=>true, 'message'=>" Empleados Disponibles  ", 'obj'=>$employees );
  }


echo json_encode($responce);
