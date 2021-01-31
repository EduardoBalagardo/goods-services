import { Component, OnInit } from '@angular/core';
import { PurchaseOrderService } from '../../services/purchase-order.service';
import { AuthService } from '../../services/auth.service';
import { CatalogsService } from '../../services/catalogs.service';
import { Router } from '@angular/router';
import { getUrlScheme } from '@angular/compiler';
import { UnidadMedida } from 'src/app/models/unidad-medida.model';

@Component({
  selector: 'app-autotizaciones',
  templateUrl: './autotizaciones.component.html',
  styleUrls: ['./autotizaciones.component.css']
})
export class AutotizacionesComponent implements OnInit {
  oc:any[]  = [];
  uds:UnidadMedida[] = [];
  ocd:any[]=[];
  tocd = 0;
  unicode:string="";
  proyecto:string;
  dataSend:any[]=[];

  constructor(private auth:AuthService, private ps:PurchaseOrderService, private cat:CatalogsService,  private router: Router) { }
   ngOnInit() {

    this.ps.getAllELemets('autorization_list','1').subscribe( res=>{
      this.oc = res.obj;
    });

    this.cat.getAnyCatalogs('unidadesmedida').subscribe(res=>{
      this.uds = res.obj;
    })


  }


  getLabel(item:number):string{
    for(let i = 0; i<this.uds.length; i++){
      if(item == this.uds[i].uds_id){
        return this.uds[i].uds_descripcion;
      }
    }
  }
  getSumAll() : number {
    let total = 0;
    for(let i = 0; i<this.oc.length; i++){
      total+=this.oc[i].total;
    }
    return total;
  }

  setDetailArray(detail:any){
    this.unicode  = detail.purchase_order[0].unicode;
    this.proyecto = detail.purchase_order[0].ord_proyecto
    this.ocd = detail.purchase_order_detail;
    this.tocd = 0;
    for(let i = 0; i<this.ocd.length; i++){
      this.tocd += this.getTotal(this.ocd[i].prd_cantidad,this.ocd[i].prd_pro_precio_unitario)
    }

  }

  getTotal(a:number,b:number):number{
    return a * b;
  }

  arrAutorization(e:any){
    let flag = false;
    let index = -1;
    if(this.dataSend.length>0){
      for(let i = 0; i<this.dataSend.length; i++){
        if(e == this.dataSend[i])
        {
          flag = true;
          index = i;
          break;
        }
      }
      if(flag == true ){
        this.dataSend.splice(this.dataSend.indexOf(index),1);
      }else{
        this.dataSend.push( parseInt(e) );
      }
    }else{
      this.dataSend.push( parseInt(e) );
    }
  }

  sendAutorized(){
     let obj = {obj:this.dataSend, type:'autorization'};
     this.ps.postPurchaseAutorizes(obj).subscribe(res=>{
     this.ps.getAllELemets('autorization_list','1').subscribe( res=>{
        this.oc = res.obj;
      });
   })
  }


  redirect(type:string){
    if(type == 'purchase-order'){
      this.router.navigate(['purchase-order']);

    }
  }
}
