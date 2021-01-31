import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { AuthService } from '../../services/auth.service';
import { DeparturesWarehouseService } from '../../services/departures-warehouse.service';
import { CatalogsService } from '../../services/catalogs.service';
import { NgForm } from '@angular/forms';

@Component({
  selector: 'app-departures-warehouse',
  templateUrl: './departures-warehouse.component.html',
  styleUrls: ['./departures-warehouse.component.css']
})
export class DeparturesWarehouseComponent implements OnInit {
  entries:any[]=[];
  entriesDetail:any[]=[];
  entriesTotal:number=0;
  catEmpleados:any[]=[];
  _catEmpleado:any;
  constructor(private auth:AuthService, private dw:DeparturesWarehouseService, private cat:CatalogsService, private router:Router) { }

  ngOnInit() {

    this.dw.getAllELemets('all_entries','1').subscribe(res=>{      
        this.entries = res.obj;      
        this.cat.getAnyCatalogs('empleados').subscribe(res =>{          
          this.catEmpleados = res.obj;
        });
    });

  }

  setDetailArray(ent:any){    
    this.entriesTotal = 0;
    this.entriesDetail = ent.entrie_detailed; 
    for(let i = 0; i<this.entriesDetail.length; i++){
      this.entriesTotal+= parseInt(this.entriesDetail[i].end_stock);
    }  
  }

  addNewDelivery()
  {


  }

  deliverySend(form:NgForm){
    console.log(form);

  }

  validate()
{
  console.log(this._catEmpleado);
}
}
