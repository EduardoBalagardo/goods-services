import { Component, OnInit } from '@angular/core';
import { PurchaseOrderService } from '../../services/purchase-order.service';
import { AuthService } from '../../services/auth.service';
import { CatalogsService } from '../../services/catalogs.service';
import { Router } from '@angular/router';
import { UnidadMedida } from 'src/app/models/unidad-medida.model';

@Component({
  selector: 'app-quatations',
  templateUrl: './quatations.component.html',
  styleUrls: ['./quatations.component.css']
})
export class QuatationsComponent implements OnInit {
  oc:any[]  = [];
  uds:UnidadMedida[] = [];
  ocd:any[]=[];
  tocd = 0;
  unicode:string="";
  proyecto:string;
  dataSend:any[]=[];
  baseUrl="http://localhost:8080/goods-services/api/" // PC
  //baseUrl="http://localhost:8080/goods-services/api/"; //LAPTOP
  //baseUrl="http://www.hempmex.com/goods-services/api/" // Hemp
  pdfSrc:string;
  constructor(private auth:AuthService, private ps:PurchaseOrderService, private cat:CatalogsService, private router:Router) { }

  ngOnInit() {
    this.ps.getAllELemets('autorization_list','2 OR ord_estatus = 3').subscribe( res=>{
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

  printPDF(detail:any){

    this.pdfSrc = this.baseUrl + 'repositorie/' + detail.purchase_order[0].unicode +'.pdf';
    /**

    console.log(this.pdfSrc);
    **/
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

  redirect(type:string){
    if(type == 'autorizations'){
      this.router.navigate(['autorizations']);

    }
  }

  sendQuoatations(){
    let obj = {obj:this.dataSend, type:'quoatation'};
    this.ps.postPurchaseAutorizes(obj).subscribe(res => {
      this.ps.getAllELemets('autorization_list','2 OR ord_estatus = 3 ORDER BY ord_estatus' ).subscribe( res=>{
        this.oc = res.obj;
      });
    });
  }

  setFactura(o:any){

    this.pdfSrc = this.baseUrl + 'repositorie/' +  o.purchase_order[0].factura +'.pdf';
  }


}
