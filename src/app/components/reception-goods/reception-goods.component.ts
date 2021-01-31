import { Component, OnInit } from '@angular/core';
import { AuthService } from '../../services/auth.service';
import { CatalogsService } from '../../services/catalogs.service';
import { ContractualService } from '../../services/contractual.service';
import { Router } from '@angular/router';
import { UnidadMedida } from 'src/app/models/unidad-medida.model';

@Component({
  selector: 'app-reception-goods',
  templateUrl: './reception-goods.component.html',
  styleUrls: ['./reception-goods.component.css']
})
export class ReceptionGoodsComponent implements OnInit {
  oc:any[] =[];
  ocd:any[]=[];
  tocd:number=0;
  uds:UnidadMedida[] = [];
  dataSend:any[]=[];
  nombreCompany :string = "";
  pdfSrc:string="";
  //baseUrl="http://localhost:8080/goods-services/api/" // PC
  baseUrl="http://localhost/goods-services/api/"; //LAPTOP
  //baseUrl="http://www.hempmex.com/goods-services/api/" // Hemp
  constructor(private auth:AuthService, private cs:ContractualService, private cat:CatalogsService, private router:Router) { }
  ngOnInit() {

    this.cs.getAllELemets('contractual_order','1').subscribe( res=>{
      this.oc = res.obj;     
    });

  }

  setDetailArray(e:any){
    for(let i = 0; i<this.oc.length; i++){
      if( e.purchase_contractual.orc_id == this.oc[i].purchase_contractual.orc_id){
        this.ocd = this.oc[i].purchase_contractual_detail;
        for(let c = 0; c<this.ocd.length; c++){
          this.tocd += parseFloat(this.ocd[c].ocd_total);
        }
        this.nombreCompany = this.oc[i].purchase_contractual.prv_nombre;

      }
    }
  }

  getLabel(item:number):string{
    for(let i = 0; i<this.uds.length; i++){
      if(item == this.uds[i].uds_id){
        return this.uds[i].uds_descripcion;
      }
    }
  }

  getUnit(a:number, b:number){
    return b / a;
  }

  printPDF(item:string){
    this.pdfSrc = this.baseUrl + 'repositorie/' +  item +'.pdf';
  }

  changeStatus( c:any){
    let count = 0;
    c.ocd_estatus = (c.ocd_estatus == 0) ? 1 : 0;
    for(let i = 0; i<this.ocd.length; i++){
      if(this.ocd[i].ocd_estatus == 1){
        count++;
      }
    }
    if( count == this.ocd.length ){
      this.arrAutorization(this.ocd[0].ocd_orc_id);
      for(let i = 0; i<this.oc.length; i++){
        if( this.ocd[0].ocd_orc_id == this.oc[i].purchase_contractual.orc_id){
          this.oc[i].purchase_contractual.orc_estatus = 9;
          break;
        }
      }
    } else {
      for(let i = 0; i<this.oc.length; i++){
        if( this.ocd[0].ocd_orc_id == this.oc[i].purchase_contractual.orc_id){
          this.oc[i].purchase_contractual.orc_estatus = 1;
          break;
        }
      }
    }
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

  sendEntries(){
    this.cs.postAll(this.dataSend).subscribe(res=>{
      this.cs.getAllELemets('contractual_order','1').subscribe( res=>{
        this.oc = res.obj;
      });
    })
  }
}
