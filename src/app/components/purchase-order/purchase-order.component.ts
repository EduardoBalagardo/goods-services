import { Component, OnInit } from '@angular/core';
import { AuthService } from '../../services/auth.service';
import { Router } from '@angular/router';
import { CatalogsService } from '../../services/catalogs.service';
import { CentroCostos } from '../../models/centro-costos.model';
import { Presupuestos } from '../../models/presupuestos.model';
import { Puestos } from '../../models/puestos.model';
import { Profiles } from '../../models/profiles.model';
import { Empleados } from '../../models/empleados.model';
import { PurchaseOrder } from '../../models/purchase-order.model';
import { PurchaseOrderService } from '../../services/purchase-order.service';
import { NgForm } from '@angular/forms';
import { Proveedores } from '../../models/proveedores.model';
import { CategoriasProductos } from '../../models/categorias-productos.model';
import { Productos } from '../../models/productos.model';
import { PurchaseDetail } from 'src/app/models/purchase-detail.model';
import { UnidadMedida } from 'src/app/models/unidad-medida.model';
@Component({
  selector: 'app-purchase-order',
  templateUrl: './purchase-order.component.html',
  styleUrls: ['./purchase-order.component.css']
})
export class PurchaseOrderComponent implements OnInit {

  purchaseOrdersResumen:any[]=[];
  catCentroCostos: CentroCostos[] = [];
  catRubrosPresupuestales: Presupuestos[] = [];
  catPuestos: Puestos[] = [];
  catPerfiles: Profiles[] = [];
  catPurchasesOrders: PurchaseOrder[] = [];
  catProveedores: Proveedores[] = [];
  categoriasProductos: CategoriasProductos[] = [];
  catProductos: Productos[] = [];
  catSubProductos: Productos[] = [];
  catPurchaseDetail: PurchaseDetail[] = [];
  catUnidadesDeMeida: UnidadMedida[] = [];
  _catCentroCosto: CentroCostos = { cec_id: 0, cec_clave: '', cec_descripcion: '', cec_status: 1, cec_type: '' }
  _catRubroPresupuestal: Presupuestos = { rup_id: 0, rup_clave: '', rup_descripcion: '', rup_status: 0, rup_type: '' };
  _catPuesto: Puestos = { pto_id: 0, pto_clave: '', pto_descripcion: '', pto_status: 0, pto_type: '' };
  _catProfile: Profiles = { usr_id: 0, usr_clave: '', usr_descripcion: '', usr_status: 0, usr_type: '' };
  _catEmpleado: Empleados = { emp_id: 0, emp_clave: '', emp_fullname: '', emp_mail:'', emp_telefono:'', emp_user: '', emp_pass: '', emp_cec_id: 0, emp_id_puesto: 0, emp_type: '' }
  _catPurchaseOrder: PurchaseOrder = { ord_id: 0, cec_id: 0, prv_id:0,  emp_id: 0, rup_id: 0, ord_estatus: 0, ord_fecha: '', ord_responsable: '', ord_proyecto:'', ord_detalle: '', ord_clave: '', ord_factura:'', ord_type: '' }
  _catProveedor: Proveedores = { prv_id: 0, prv_nombre: '', prv_giro: '',  prv_direccion: '', prv_telefono: '', prv_rfc: '',  prv_mail: '',prv_type: '' }
  _catCategoriaProduto: CategoriasProductos = { cat_id: 0, cat_clave: '', cat_descripcion: '', cat_estatus: 0, cat_type: '' };
  _catProducto: Productos = { pro_id: 0, pro_cat_id: 0, pro_prv_id: 0, pro_uds_id: 0, pro_clave: '', pro_cantidad: 0, pro_precio_unitario: 0, pro_precio_total: 0, pro_descripcion: '', pro_type: '' }
  _catPurchaseDetail:PurchaseDetail   = { prd_id: 0, prd_ord_id: 0, prd_pro_id:0, prd_pro_descripcion: '', prd_cantidad: 0, prd_uds_id: 0, prd_pro_precio_unitario: 0, prd_pro_precio_total: 0, prd_type: '' };
  _catUnidadDeMedida: UnidadMedida = { uds_id: 0, uds_clave: '', uds_descripcion: '', uds_estatus: 0, uds_type: '' };
  enablesAll: boolean = false;
  detailOC: boolean = false;
  categorieLabel: string = '';
  idNewOC: any;
  total:number=0;
  cantidad:number=0;
  idsAproved:number[]=[];
  constructor(private auth: AuthService, private router: Router, private cat: CatalogsService, private pur: PurchaseOrderService) { }
  ngOnInit() {
    if (!this.auth.userObj) {
      localStorage.removeItem('uid');
      this.auth.loggedInStauts = false;
      this.router.navigate(['user-login']);
    } else {
      this._catEmpleado = this.auth.userObj.user[0];
      this.catGetCentroCostos();
      this.catGetProfile();
      this.catGetPuesto();
      this.catGetRubrosPresupuestales();
      this.catGetCategoriasProductos();
      this.catGetProveedores();
      this.catGetProductos();
      this.catGetUnidadDeMedida();
      this.catGetPurchaseOrders();

      /// Set elemts from purchase_order
      this._catPurchaseOrder.ord_responsable = this._catEmpleado.emp_fullname;
      this._catPurchaseOrder.emp_id = this._catEmpleado.emp_id;
      this._catPurchaseOrder.ord_clave = this._catEmpleado.emp_clave;
      this._catPurchaseOrder.ord_fecha = 'Date';
      this._catPurchaseOrder.ord_estatus = 1;
      this._catPurchaseOrder.cec_id = this._catEmpleado.emp_cec_id;
    }
  }
  catGetCentroCostos() {
    this.cat.getCentroCostos().subscribe(
      res => {
        this.catCentroCostos = res.obj;

        for (let i = 0; i < this.catCentroCostos.length; i++) {
          if (this._catEmpleado.emp_cec_id == this.catCentroCostos[i].cec_id) {
            this._catCentroCosto = this.catCentroCostos[i];
            this._catCentroCosto.cec_type = '';
            break;
          }
        }
      });
  }

  catGetRubrosPresupuestales() {
    this.cat.getRubroPresupuestal().subscribe(
      res => {
        this.catRubrosPresupuestales = res.obj;
        //console.log(this.catRubrosPresupuestales);
      }
    )
  }

  catGetPuesto() {
    this.cat.getPuestos().subscribe(res => {
      this.catPuestos = res.obj;
      for (let i = 0; i < this.catPuestos.length; i++) {
        if (this._catEmpleado.emp_id_puesto == this.catPuestos[i].pto_id) {
          this._catPuesto = this.catPuestos[i];
          break;
        }
      }
      //console.log(this.catPuestos);
    })
  }

  catGetProfile() {
    this.cat.getProfileUser().subscribe(res => {
      this.catPerfiles = res.obj;
      //console.log(this.catPerfiles);
    })
  }

  catGetProveedores() {
    this.cat.getAnyCatalogs('proveedores').subscribe(res => {
      this.catProveedores = res.obj;
      //console.log(this.catProveedores);
    });
  }

  catGetCategoriasProductos() {
    this.cat.getAnyCatalogs('categoriasprod').subscribe(res => {
      this.categoriasProductos = res.obj;
      //console.log(this.categoriasProductos);
    });
  }

  catGetProductos() {
    this.cat.getAnyCatalogs('productos').subscribe(res => {
      this.catProductos = res.obj;
      //console.log(this.catProductos);
    });
  }

  catGetUnidadDeMedida() {
    this.cat.getAnyCatalogs('unidadesmedida').subscribe(res => {
      this.catUnidadesDeMeida = res.obj;
    });
  }

  catGetPurchaseOrders(){
    this.cat.getAnyCatalogs('resumenrubros').subscribe(res => {
      this.purchaseOrdersResumen = res.obj;
    });
  }

  submitPurchaseOrd(form: NgForm) {

    this.pur.postPurchaseOrde(this._catPurchaseOrder).subscribe(res => {
      this.enablesAll = true;
      this.idNewOC = res.obj.id;
    })

  }

  setRubro() {
    this._catPurchaseOrder.rup_id = this._catRubroPresupuestal.rup_id;
  }

  selectJustCat() {
    this.catSubProductos = [];
    for (let i = 0; i < this.catProductos.length; i++) {
      if (this._catCategoriaProduto.cat_id == this.catProductos[i].pro_cat_id && this._catProveedor.prv_id == this.catProductos[i].pro_prv_id ) {
        this.catProductos[i].pro_type = '';
        this.catSubProductos.push(this.catProductos[i]);
      }
    }

  }

  setPreviousFields() {
    this._catPurchaseDetail.prd_pro_precio_unitario = this._catProducto.pro_precio_unitario;
    this._catPurchaseDetail.prd_uds_id = this._catProducto.pro_uds_id;

    for (let i = 0; i < this.catUnidadesDeMeida.length; i++) {
      if (this.catUnidadesDeMeida[i].uds_id === this._catProducto.pro_uds_id) {
        this.categorieLabel = this.catUnidadesDeMeida[i].uds_descripcion;
      }
    }
    this._catPurchaseDetail.prd_cantidad = 0;
    this._catPurchaseDetail.prd_pro_precio_total = 0;
  }
  chageUpper(){
    this._catPurchaseOrder.ord_proyecto.toUpperCase();
  }

  getPricePerItem(){
    this._catPurchaseDetail.prd_pro_precio_total = this._catPurchaseDetail.prd_cantidad * this._catProducto.pro_precio_unitario;
  }

  selectProovedor(){

    this._catPurchaseOrder.prv_id = this._catProveedor.prv_id;
    this.catSubProductos = [];
    this._catCategoriaProduto = { cat_id: 0, cat_clave: '', cat_descripcion: '', cat_estatus: 0, cat_type: '' };
    this._catProducto = { pro_id: 0, pro_cat_id: 0, pro_prv_id: 0, pro_uds_id: 0, pro_clave: '', pro_cantidad: 0, pro_precio_unitario: 0, pro_precio_total: 0, pro_descripcion: '', pro_type: '' };
  }

  addElementOC(form:NgForm){
    this._catPurchaseDetail.prd_ord_id = this.idNewOC;
    this._catPurchaseDetail.prd_pro_descripcion = this._catProducto.pro_descripcion;
    this._catPurchaseDetail.prd_pro_id          = this._catProducto.pro_id;
    this.catPurchaseDetail.push(this._catPurchaseDetail);
    for(let i = 0; i<this.catPurchaseDetail.length; i++){
      this.total += this.catPurchaseDetail[i].prd_pro_precio_total;
    }
    this._catPurchaseDetail  = { prd_id: 0, prd_ord_id: 0, prd_pro_id:0, prd_pro_descripcion: '', prd_cantidad: 0, prd_uds_id: 0, prd_pro_precio_unitario: 0, prd_pro_precio_total: 0, prd_type: '' };
  }

  deleteItemsOC( ocD:number ){
    //let i = this.catPurchaseDetail.indexOf(ocD);
    this.catPurchaseDetail.splice(ocD,1);
    this.total = 0;
    for(let i = 0; i<this.catPurchaseDetail.length; i++){
      this.total += this.catPurchaseDetail[i].prd_pro_precio_total;
      this.cantidad += this.catPurchaseDetail[i].prd_cantidad;
    }


  }

  sendItemsOC(){
    this.pur.postPurchaseDetail(this.catPurchaseDetail).subscribe(res=>{
      this.categorieLabel = '';
      this._catProducto = { pro_id: 0, pro_cat_id: 0, pro_prv_id: 0, pro_uds_id: 0, pro_clave: '', pro_cantidad: 0, pro_precio_unitario: 0, pro_precio_total: 0, pro_descripcion: '', pro_type: '' };
      this._catRubroPresupuestal = { rup_id: 0, rup_clave: '', rup_descripcion: '', rup_status: 0, rup_type: '' };
      this._catPurchaseOrder.ord_detalle = '';
      this._catPurchaseOrder.ord_proyecto = '';
      this._catProveedor  = { prv_id: 0, prv_nombre: '', prv_giro: '', prv_mail:'', prv_direccion: '', prv_telefono: '', prv_rfc: '', prv_type: '' } ;
      this.catPurchaseDetail = [];
      this.enablesAll = false;
      this.total = 0;
      this.catGetPurchaseOrders();

    })
  }




}


