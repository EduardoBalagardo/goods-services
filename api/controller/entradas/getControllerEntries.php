<?php
require_once("../../model/DataBase.php");
$db = new DataBase(IDB::DB);
$type = $_GET['type'];
$subtype = (isset($_GET['subType'])  ? $_GET['subType'] : '') ;
$responce = array( 'success'=>false,'message'=>' Peticion equivocada ','obj'=>array()  );

if($type == 'all_entries')
{
  $sql = "SELECT * FROM entries_storages  INNER JOIN  cat_proveedores ON cat_proveedores.prv_id = entries_storages.ent_prv_id WHERE ent_estatus = $subtype";    
  $entries = $db->get($sql);
  $allEntries = array();    
  $arrEntries = array();  
  if(count($entries)>0){    
    for($i = 0; $i<count($entries); $i++ ) {
      $arrEntries = array();
      $arrEntries[$i] = array('ent_fecha'=>$entries[$i]['ent_fecha'],
      'ent_factura'=>$entries[$i]['ent_factura'],
      'ent_cantidad'=>$entries[$i]['ent_cantidad'],
      'ent_total'=>$entries[$i]['ent_total'],
      'prv_nombre'=>utf8_decode($entries[$i]['prv_nombre']),
      'ent_factura'=>$entries[$i]['ent_factura']);
      $sql = "SELECT * FROM entries_storages_detail WHERE end_ent_id = {$entries[$i]['ent_id']} AND end_estatus = 1";
      $entriesDetailed = $db->get($sql);
      $arrEntrieDetailes = array();
      if(count($entriesDetailed)>0){
        for($e = 0; $e<count($entriesDetailed); $e++){
          $arrEntrieDetailes[$e] = array(
            'end_pro_id'=>$entriesDetailed[$e]['end_pro_id'],
            'end_nombre_bien'=>utf8_decode($entriesDetailed[$e]['end_nombre_bien']),
            'end_stock'=>$entriesDetailed[$e]['end_stock'],                        
          );
        }
      }
      $allEntries[$i]['entrie'] = $arrEntries[$i];
      $allEntries[$i]['entrie_detailed'] = $arrEntrieDetailes;
    }
  }    
  $responce = array( 'success'=>true,'message'=>' Todas las entradas con detalle ','obj'=>$allEntries  );
}


echo json_encode($responce);

?>