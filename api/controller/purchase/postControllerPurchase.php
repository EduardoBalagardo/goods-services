<?php
session_start();
require_once("../../model/DataBase.php");
require_once '../../model/libraries/fpdf17/fpdf.php';
require_once '../../model/libraries/EnLetras.php';
$db = new DataBase(IDB::DB);
$user = array();
$responce = array('success'=>false, 'message'=>"Bad Request", 'obj'=>array());
$_POST = json_decode(file_get_contents('php://input'), true);
  $baseUrl="http://localhost:8080/goods-services/api/";// PC
  //$baseUrl="http://localhost/goods-services/api/"; //LAPTOP
  //$baseUrl="http://www.hempmex.com/goods-services/api/"; // Hemp
//Enviar Purchase Order
if (isset($_POST['purchaseOrder'])) {
    $cec_id = $_POST['purchaseOrder']['cec_id'];
    $emp_id = $_POST['purchaseOrder']['emp_id'];
    $rup_id = $_POST['purchaseOrder']['rup_id'];
    $prv_id = $_POST['purchaseOrder']['prv_id'];
    $ord_proyecto = $_POST['purchaseOrder']['ord_proyecto'];
    $fecha =  date("Y-m-d h:i:s");
    $ord_responsable  = $_POST['purchaseOrder']['ord_responsable'];
    $ord_clave        = $_POST['purchaseOrder']['ord_clave'];
    $ord_detalle      = $_POST['purchaseOrder']['ord_detalle'];
    $sql  = "INSERT INTO `purchase_order`( `cec_id`, `emp_id`, `rup_id`, `prv_id`, `ord_estatus`, `ord_fecha`, `ord_responsable`, `ord_proyecto`, `ord_clave`, `ord_detalle`,`ord_factura`) ";
    $sql .= "VALUES ( {$cec_id} ,{$emp_id},{$rup_id},{$prv_id}, 1,'{$fecha}','{$ord_responsable}','{$ord_proyecto}','{$ord_clave}','{$ord_detalle}','@@@@')";

    $id = $db->getIdRow($sql);

    if ($id['status'] == true) {
        $responce = array('success'=>true, 'message'=>"Purchase Order Inserted", 'obj'=>$id);
    }
}

//Enviar Detalle de Orden de Compra
if (isset($_POST['purchaseDetail'])) {
    $c = 0;
    $values = '';
    for ($i=0; $i<count($_POST['purchaseDetail']); $i++) {
        $prd_ord_id              = $_POST['purchaseDetail'][$i]['prd_ord_id'];
        $prd_pro_descripcion     = $_POST['purchaseDetail'][$i]['prd_pro_descripcion'];
        $prd_cantidad            = $_POST['purchaseDetail'][$i]['prd_cantidad'];
        $prd_pro_id              = $_POST['purchaseDetail'][$i]['prd_pro_id'];
        $prd_pro_precio_total    = $_POST['purchaseDetail'][$i]['prd_pro_precio_total'];
        $prd_pro_precio_unitario = $_POST['purchaseDetail'][$i]['prd_pro_precio_unitario'];
        $prd_uds_id              = $_POST['purchaseDetail'][$i]['prd_uds_id'];
        $values .= ($i==count($_POST['purchaseDetail'])-1) ? " ($prd_ord_id,'$prd_pro_descripcion',$prd_cantidad,$prd_pro_id,$prd_uds_id,$prd_pro_precio_unitario,$prd_pro_precio_total)" : "($prd_ord_id,'$prd_pro_descripcion',$prd_cantidad,$prd_pro_id,$prd_uds_id,$prd_pro_precio_unitario,$prd_pro_precio_total), ";
        //
    }
    $sql = " INSERT INTO `purchase_order_detail`( `prd_ord_id`, `prd_pro_descripcion`, `prd_cantidad`, `prd_pro_id`, `prd_uds_id`, `prd_pro_precio_unitario`, `prd_pro_precio_total`) VALUES $values";

    if ($db->put($sql)) {
      $responce = array('success'=>true, 'message'=>"Purchase  Detailed Order Inserted", 'obj'=>$_POST['purchaseDetail']);
  }
}

//Enviar Autorizacion de Ordenes de Compra
if (isset($_POST['purchaseAutorized'])) {

    $letter = new EnLetras();
    $ocs    = array();
    $db->isFinancial = ($_POST['purchaseAutorized']['type']=='autorization') ? false : true ;
    if (count($_POST['purchaseAutorized']['obj'])>0) {
        for ($i=0; $i<count($_POST['purchaseAutorized']['obj']);$i++) {
            $sql = "SELECT ord_id, ord_fecha, ord_responsable,  cat_puestos.pto_descripcion, ord_proyecto, ord_clave, ord_detalle, ord_estatus, cat_empleados.emp_id,
      cat_centro_costos.cec_id, cat_centro_costos.cec_descripcion, cat_rubro_presupuestal.rup_descripcion, cat_proveedores.prv_id, cat_proveedores.prv_nombre,
      cat_proveedores.prv_direccion, cat_proveedores.prv_telefono, cat_proveedores.prv_rfc, cat_proveedores.prv_mail,cat_puestos.pto_descripcion, cat_empleados.emp_mail, cat_empleados.emp_telefono, cat_empleados.emp_clave
      FROM `purchase_order`
      INNER JOIN cat_centro_costos ON cat_centro_costos.cec_id = purchase_order.cec_id
      INNER JOIN cat_rubro_presupuestal ON cat_rubro_presupuestal.rup_id = purchase_order.rup_id
      INNER JOIN cat_proveedores ON cat_proveedores.prv_id= purchase_order.prv_id
      INNER JOIN cat_empleados ON cat_empleados.emp_id = purchase_order.emp_id
      INNER JOIN cat_puestos ON cat_puestos.pto_id = cat_empleados.emp_id_puesto
      WHERE ord_id = " . $_POST['purchaseAutorized']['obj'][$i];
            $pdfData = array();
            $pdfData = $db->get($sql);
            $ocName = "OC".str_pad($pdfData[0]['ord_id'], 5, '0', STR_PAD_LEFT).str_pad($pdfData[0]['cec_id'], 3, '0', STR_PAD_LEFT);
            $pdf = new FPDF();
            $pdf->AddPage();
            //DATOS DE LA EMPRESA EDUCANDO SA
            $pdf->SetFont('Helvetica', '', 8);
            $pdf->SetFillColor(252, 252, 253);
            $pdf->SetY(15);
            $pdf->SetX(10);
            $pdf->Cell(25, 6, "Descricpcion : ", 0, 'L', 1);
            $pdf->SetX(30);
            $pdf->Cell(25, 6, utf8_decode(" ORDEN DE COMPRA  "), 0, 'L', 1);
            $pdf->SetX(140);
            $pdf->Cell(25, 6, "Reporte: ", 0, 'L', 1);
            $pdf->SetX(152);
            $pdf->Cell(25, 6, "OC".str_pad($pdfData[0]['ord_id'], 5, '0', STR_PAD_LEFT).str_pad($pdfData[0]['ord_clave'], 3, '0', STR_PAD_LEFT), 0, 'L', 1);
            $pdf->SetY(19);
            $pdf->SetX(10);
            $pdf->Cell(25, 6, utf8_decode("Razón Social: "), 0, 'L', 1);
            $pdf->SetX(30);
            $pdf->Cell(25, 6, trim(utf8_encode(strtoupper("Educando S.A. En la Empresa Educando S.A. "))), 0, 'L', 1);
            $pdf->SetX(140);
            $pdf->Cell(25, 6, "Fecha: " . date('Y-d-m/h:m:s'), 0, 'L', 1);
            $pdf->SetY(23);
            $pdf->SetX(10);
            $pdf->Cell(25, 6, utf8_decode("Direccion De Entrega: Mexico - Queretaro km 36.8, Luis Echeverria, 54700 Cuautitlán Izcalli, Méx."), 0, 'L', 1);
            $pdf->SetX(30);
            //DATOS DEL PROVEEDOR
            $pdf->SetFont('Helvetica', 'B', 8);
            $pdf->SetY(33);
            $pdf->SetX(10);
            $pdf->Cell(25, 6, utf8_decode(" Datos del Proveedor "), 0, 'L', 1);
            $pdf->SetY(37);
            $pdf->SetX(10);
            $pdf->Cell(25, 6, utf8_decode(" Proveedor : " . $pdfData[0]['prv_nombre']), 0, 'L', 1);
            $pdf->SetY(41);
            $pdf->SetX(10);
            $pdf->Cell(25, 6, utf8_decode(utf8_encode(" Direccion  : " . $pdfData[0]['prv_direccion'])), 0, 'L', 1);
            $pdf->SetY(45);
            $pdf->SetX(10);
            $pdf->Cell(30, 6, utf8_decode(utf8_encode(" RFC  : " . $pdfData[0]['prv_rfc'])), 0, 'L', 1);
            $pdf->SetX(50);
            $pdf->Cell(40, 6, utf8_decode(utf8_encode(" Telefono  : " . $pdfData[0]['prv_telefono'])), 0, 'L', 1);
            $pdf->SetX(90);
            $pdf->Cell(30, 6, utf8_decode(utf8_encode(" Correo  : " . $pdfData[0]['prv_mail'])), 0, 'L', 1);
            $pdf->SetY(53);
            $pdf->SetX(10);
            $pdf->Cell(25, 6, utf8_decode(" Datos del Solicitante "), 0, 'L', 1);
            $pdf->SetFont('Helvetica', '', 8);
            $pdf->SetY(57);
            $pdf->SetX(10);
            $pdf->Cell(50, 6, utf8_decode(" Nombre : " . $pdfData[0]['ord_responsable']), 0, 'L', 1);
            $pdf->SetX(60);
            $pdf->Cell(60, 6, utf8_decode(" Proyecto : " .strtoupper($pdfData[0]['ord_proyecto'])), 0, 'L', 1);
            $pdf->SetX(120);
            $pdf->Cell(30, 6, utf8_decode(" Correo : " .strtolower($pdfData[0]['emp_mail'])), 0, 'L', 1);
            $pdf->SetY(61);
            $pdf->SetX(10);
            $pdf->Cell(50, 6, utf8_decode(" Centro de Costos : " . $pdfData[0]['cec_descripcion']), 0, 'L', 1);
            $pdf->SetX(60);
            $pdf->Cell(60, 6, utf8_decode(" Puesto : " .strtoupper($pdfData[0]['pto_descripcion'])), 0, 'L', 1);
            $pdf->SetX(120);
            $pdf->Cell(30, 6, utf8_decode(" Telefono : " .strtolower($pdfData[0]['emp_telefono'])), 0, 'L', 1);
            $pdf->SetFont('Helvetica', 'B', 8);
            $pdf->SetY(70);
            $pdf->SetX(10);
            $pdf->Cell(50, 6, utf8_decode(" Desgloce   ".$ocName), 0, 'L', 1);
            $pdf->SetFont('Helvetica', 'B', 6);
            $pdf->SetY(75);
            $pdf->SetX(20);
            $pdf->Cell(50, 6, utf8_decode("Cantidad"), 0, 'L', 1);
            $pdf->SetX(30);
            $pdf->Cell(60, 6, utf8_decode("Detalle"), 0, 'L', 1);
            $pdf->SetX(100);
            $pdf->Cell(20, 6, utf8_decode("Costo"), 0, 'L', 1);
            $pdf->SetX(120);
            $pdf->Cell(20, 6, utf8_decode("Total"), 0, 'L', 1);
            $sql = "SELECT * FROM purchase_order_detail
                    INNER JOIN cat_unidad_medida ON cat_unidad_medida.uds_id = purchase_order_detail.prd_uds_id
                    WHERE prd_ord_id = {$_POST['purchaseAutorized']['obj'][$i]} ORDER BY prd_id";
            $r = 80;
            $pdf->SetFont('Helvetica', '', 8);
            $detail =  array();
            $detail = $db->get($sql);
            $total = 0;
            $cantidad = 0;
            if (count($detail)>0) {
                for ($d=0; $d<count($detail); $d++) {
                    $cantidad += (int)$detail[$d]['prd_cantidad'];
                    $total    += (int)$detail[$d]['prd_pro_precio_total'];
                    $pdf->SetY($r);
                    $pdf->SetX(20);
                    $pdf->Cell(50, 6, utf8_decode(strtoupper(substr($detail[$d]['prd_cantidad'], 0, 32))), 0, 'L', 1);
                    $pdf->SetX(30);
                    $pdf->Cell(60, 6, utf8_decode(strtoupper(substr($detail[$d]['prd_pro_descripcion'], 0, 32))), 0, 'L', 1);
                    $pdf->SetX(100);
                    $pdf->Cell(20, 6, $db->filter($detail[$d]['prd_pro_precio_unitario'], 'currency'), 0, 'L', 1);
                    $pdf->SetX(120);
                    $pdf->Cell(20, 6, $db->filter($detail[$d]['prd_pro_precio_total'], 'currency'), 0, 'L', 1);
                    $r = $r+4;
                }
            }
            $pdf->SetFont('Helvetica', 'B', 8);
            $pdf->SetY($r);
            $pdf->SetX(20);
            $pdf->Cell(50, 6, $cantidad, 0, 'L', 1);
            $pdf->SetX(30);
            $pdf->Cell(60, 6, "Totales", 0, 'L', 1);
            $pdf->SetX(100);
            $pdf->Cell(20, 6, "", 0, 'L', 1);
            $pdf->SetX(120);
            $pdf->Cell(20, 6, $db->filter($total, 'currency'), 0, 'L', 1);
            //
            $r = $r + 4;
            $iva = $total*.16;
            $pdf->SetFont('Helvetica', 'B', 8);
            $pdf->SetY($r);
            $pdf->SetX(20);
            $pdf->Cell(50, 6, "", 0, 'L', 1);
            $pdf->SetX(30);
            $pdf->Cell(60, 6, "IVA 16%", 0, 'L', 1);
            $pdf->SetX(100);
            $pdf->Cell(20, 6, "", 0, 'L', 1);
            $pdf->SetX(120);
            $pdf->Cell(20, 6, $db->filter($iva, 'currency'), 0, 'L', 1);
            $r = $r + 4;

            $pdf->SetFont('Helvetica', 'B', 8);
            $pdf->SetY($r);
            $pdf->SetX(20);
            $pdf->Cell(50, 6, "", 0, 'L', 1);
            $pdf->SetX(30);
            $pdf->Cell(60, 6, "Total con IVA", 0, 'L', 1);
            $pdf->SetX(100);
            $pdf->Cell(20, 6, "", 0, 'L', 1);
            $pdf->SetX(120);
            $pdf->Cell(20, 6, $db->filter($iva + $total, 'currency'), 0, 'L', 1);
            //save
            $r = $r + 8;
            $pdf->SetFont('Helvetica', 'B', 8);
            $pdf->SetY($r);
            $pdf->SetX(20);
            $pdf->Cell(50, 6, "Importe en letra (" . $letter->ValorEnLetras( (float) $iva + $total, 'PESOS') . ')', 0, 'L', 1);
            $r = $r + 70;
            $pdf->SetFont('Helvetica', 'B', 8);

            $r = $r + 4;
            $imG = $r - 9;
            $firma = $r + 4;
            $pdf->SetY($imG);
            $pdf->SetX(30);
            $pdf->Cell(50, 6, $pdf->Image($baseUrl."assets/firmas/". trim($pdfData[0]['emp_clave']). ".PNG", $pdf->GetX(), $pdf->GetY(), 33.78), 0, 'L', 1);

            $pdf->SetY($r);
            $pdf->SetX(30);
            $pdf->Cell(50, 6, " Responsable ", 0, 'L', 1);

            $pdf->SetY($firma);
            $pdf->SetX(30);
            $pdf->Cell(50, 6, trim($pdfData[0]['ord_responsable']), 0, 'L', 1);

            $pdf->SetY($imG);
            $pdf->SetX(70);
            //$pdf->Cell(40, 40, , 0, 0, 'L', false);
            $pdf->Cell(50, 6, $pdf->Image($baseUrl."assets/firmas/0003.PNG", $pdf->GetX(), $pdf->GetY(), 33.78), 0, 'L', 1);
            //$r = $r + 12;
            $pdf->SetY($r);
            $pdf->SetX(70);
            $pdf->Cell(50, 6, " Gerente de Proyecto ", 0, 'L', 1);

            $pdf->SetY($firma);
            $pdf->SetX(70);
            $pdf->Cell(50, 6, " Leopoldo Leal del Valle ", 0, 'L', 1);

            if ($db->isFinancial == true) {
                $pdf->SetY($imG);
                $pdf->SetX(110);
                //$pdf->Cell(40, 40, , 0, 0, 'L', false);
                $pdf->Cell(50, 6, $pdf->Image($baseUrl."assets/firmas/0005.PNG", $pdf->GetX(), $pdf->GetY(), 33.78), 0, 'L', 1);
            }
            //$r = $r + 12;
            $pdf->SetY($r);
            $pdf->SetX(110);
            $pdf->Cell(50, 6, " Director Financiero ", 0, 'L', 1);

            $pdf->SetY($firma);
            $pdf->SetX(110);
            $pdf->Cell(50, 6, " A. Araceli  Barela Del Valle ", 0, 'L', 1);

            $r = $r + 4;
            $pdf->Output('../../repositorie/'.$ocName.'.pdf', 'F');

            $stat = ($db->isFinancial == true) ? 3 : 2 ;
            $sql =" UPDATE `purchase_order` SET `ord_estatus`=$stat WHERE ord_id = {$_POST['purchaseAutorized']['obj'][$i]} ";
            if ($db->put($sql)==true) {
                array_push($ocs, $ocName);
            }

            if ($db->isFinancial == true) {
                $abc = ["A","B","C","D","E","F","G","H","I"];
                $factura = rand(1, 8);

                $pdf = new FPDF();
                $pdf->AddPage();
                $faName = "FA".str_pad($pdfData[0]['ord_id'], 5, '0', STR_PAD_LEFT).str_pad($pdfData[0]['cec_id'], 3, '0', STR_PAD_LEFT);
                $ocName = "OC".str_pad($pdfData[0]['ord_id'], 5, '0', STR_PAD_LEFT).str_pad($pdfData[0]['cec_id'], 3, '0', STR_PAD_LEFT);


                //DATOS DEL PROVEEDOR
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->SetY(15);
                $pdf->SetX(10);
                $pdf->Cell(25, 6, utf8_decode($pdfData[0]['prv_nombre']), 0, 'L', 1);
                $pdf->SetY(19);
                $pdf->SetX(10);
                $pdf->Cell(25, 6, utf8_decode(utf8_encode($pdfData[0]['prv_direccion'])), 0, 'L', 1);
                $pdf->SetY(23);
                $pdf->SetX(10);
                $pdf->Cell(30, 6, utf8_decode(utf8_encode("RFC  : " . $pdfData[0]['prv_rfc'])), 0, 'L', 1);
                $pdf->SetX(50);
                $pdf->Cell(40, 6, utf8_decode(utf8_encode("Telefono  : " . $pdfData[0]['prv_telefono'])), 0, 'L', 1);
                $pdf->SetX(90);
                $pdf->Cell(30, 6, utf8_decode(utf8_encode("Correo  : " . $pdfData[0]['prv_mail'])), 0, 'L', 1);
                $pdf->SetY(27);
                $pdf->SetX(10);
                $pdf->Cell(30, 6, utf8_decode(utf8_encode("Metodo de Pago  : " . $pdfData[0]['ord_detalle'])), 0, 'L', 1);

                $pdf->SetFont('Helvetica', 'B', 8);
                $pdf->SetY(40);
                $pdf->SetX(10);
                $pdf->Cell(30, 6, utf8_decode(utf8_encode("Datos del Cliente")), 0, 'L', 1);
                $pdf->SetFont('Helvetica', '', 8);
                $pdf->SetY(44);
                $pdf->SetX(10);
                $pdf->Cell(30, 6, utf8_decode(utf8_encode("Educando S.A. En la Empresa Educando S.A.  ")), 0, 'L', 1);
                $pdf->SetY(48);
                $pdf->SetX(10);
                $pdf->Cell(30, 6, utf8_decode(utf8_encode("R.F.C. SHO821013EMA  ")), 0, 'L', 1);
                $pdf->SetX(50);
                $pdf->Cell(30, 6, utf8_decode(utf8_encode("Uso de CFDI  G01 - Adquisicion de mercancias ")), 0, 'L', 1);
                $pdf->SetX(120);
                $pdf->Cell(20, 6, "Orden de Compra " . $ocName, 0, 'L', 1);

                $pdf->SetFont('Helvetica', 'B', 14);
                $pdf->SetY(55);
                $pdf->SetX(20);
                $pdf->Cell(50, 6, "Cotizacion ", 0, 'L', 1);
                $pdf->SetFont('Helvetica', 'B', 6);

                $pdf->SetY(59);
                $pdf->SetX(20);
                $pdf->Cell(50, 6, utf8_decode("Cantidad"), 0, 'L', 1);
                $pdf->SetX(30);
                $pdf->Cell(60, 6, utf8_decode("Detalle"), 0, 'L', 1);
                $pdf->SetX(100);
                $pdf->Cell(20, 6, utf8_decode("Costo"), 0, 'L', 1);
                $pdf->SetX(120);
                $pdf->Cell(20, 6, utf8_decode("Total"), 0, 'L', 1);
                $total = 0;
                $cantidad = 0;
                $r = 70;
                $pdf->SetFont('Helvetica', '', 8);
                if (count($detail)>0) {
                    for ($d=0; $d<count($detail); $d++) {
                        $cantidad += (int)$detail[$d]['prd_cantidad'];
                        $total    += (int)$detail[$d]['prd_pro_precio_total'];
                        $pdf->SetY($r);
                        $pdf->SetX(20);
                        $pdf->Cell(50, 6, utf8_decode(strtoupper(substr($detail[$d]['prd_cantidad'], 0, 32))), 0, 'L', 1);
                        $pdf->SetX(30);
                        $pdf->Cell(60, 6, utf8_decode(strtoupper(substr($detail[$d]['prd_pro_descripcion'], 0, 32))), 0, 'L', 1);
                        $pdf->SetX(100);
                        $pdf->Cell(20, 6, $db->filter($detail[$d]['prd_pro_precio_unitario'], 'currency'), 0, 'L', 1);
                        $pdf->SetX(120);
                        $pdf->Cell(20, 6, $db->filter($detail[$d]['prd_pro_precio_total'], 'currency'), 0, 'L', 1);
                        $r = $r+4;
                    }
                }
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->SetY($r);
                $pdf->SetX(20);
                $pdf->Cell(50, 6, $cantidad, 0, 'L', 1);
                $pdf->SetX(30);
                $pdf->Cell(60, 6, "Totales", 0, 'L', 1);
                $pdf->SetX(100);
                $pdf->Cell(20, 6, "", 0, 'L', 1);
                $pdf->SetX(120);
                $pdf->Cell(20, 6, $db->filter($total, 'currency'), 0, 'L', 1);
                //
                $r = $r + 4;
                $iva = $total*.16;
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->SetY($r);
                $pdf->SetX(20);
                $pdf->Cell(50, 6, "", 0, 'L', 1);
                $pdf->SetX(30);
                $pdf->Cell(60, 6, "IVA 16%", 0, 'L', 1);
                $pdf->SetX(100);
                $pdf->Cell(20, 6, "", 0, 'L', 1);
                $pdf->SetX(120);
                $pdf->Cell(20, 6, $db->filter($iva, 'currency'), 0, 'L', 1);
                $r = $r + 4;

                $pdf->SetFont('Helvetica', 'B', 8);
                $pdf->SetY($r);
                $pdf->SetX(20);
                $pdf->Cell(50, 6, "", 0, 'L', 1);
                $pdf->SetX(30);
                $pdf->Cell(60, 6, "Total con IVA", 0, 'L', 1);
                $pdf->SetX(100);
                $pdf->Cell(20, 6, "", 0, 'L', 1);
                $pdf->SetX(120);
                $pdf->Cell(20, 6, $db->filter($iva + $total, 'currency'), 0, 'L', 1);
                //save
                $r = $r + 8;
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->SetY($r);
                $pdf->SetX(20);
                $pdf->Cell(50, 6, "Importe en letra (" . $letter->ValorEnLetras((float)$iva + $total, 'PESOS') . ')', 0, 'L', 1);
                $r = $r + 70;
                $pdf->SetFont('Helvetica', 'B', 8);
                $pdf->Output('../../repositorie/'.$faName.'.pdf', 'F');
                //Inserta Orden Contra Actual
                $fechaSolicitud = date("Y-m-d h:i:s");
                $nit      = str_pad(rand(1,1000), 4, '0', STR_PAD_LEFT).'-'.str_pad(rand(1,1000), 4, '0', STR_PAD_LEFT).'-'.str_pad(rand(1,1000), 4, '0', STR_PAD_LEFT).'-'.$abc[rand(0,8)];
                $tO = $iva + $total;
                $sql = "INSERT INTO purchase_order_contractual( orc_nit,  orc_factura, orc_prv_id,	ord_emp_id, orc_fecha_order, orc_fecha_entrega, orc_monto_total, orc_cantidad_total, orc_estatus) VALUES ('$nit','$faName',{$pdfData[0]['prv_id']} , {$pdfData[0]['emp_id']} , '$fechaSolicitud','',$tO, $cantidad, 1)";

                $id = $db->getIdRow($sql);
                $values = "";
                if($id['status']==true){
                  if (count($detail)>0) {
                    $total = 0;
                    $cantidad = 0;
                    for ($d=0; $d<count($detail); $d++) {
                        $cantidad += (int)$detail[$d]['prd_cantidad'];
                        $total    += (int)$detail[$d]['prd_pro_precio_total'];
                        $total    = (float)$detail[$d]['prd_cantidad'] * $detail[$d]['prd_pro_precio_unitario'];
                        $values .= ($d==count($detail)-1) ? " ({$detail[$d]['prd_pro_id']}, {$id['id']}, '{$detail[$d]['prd_pro_descripcion']}',{$detail[$d]['prd_cantidad']},$total) " : " ({$detail[$d]['prd_pro_id']}, {$id['id']}, '{$detail[$d]['prd_pro_descripcion']}',{$detail[$d]['prd_cantidad']},$total), ";
                    }
                    $sql = "INSERT INTO purchase_order_contractual_detail (  ocd_pro_id, ocd_orc_id,ocd_descripcion, ocd_cantidad, ocd_total) VALUES " . $values;
                    if ( $db->put($sql) == true ) {

                    }
                  }
                }
            }
            $responce = array('success'=>true,'message'=>'Se han creado todos estos archivos', 'obj'=>$ocs);
        }
    }
}


echo json_encode($responce);


