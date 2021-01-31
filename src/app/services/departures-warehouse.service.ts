import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse,  HttpHeaders } from '@angular/common/http';
import { _throw } from 'rxjs/Observable/throw';
import { Observable } from 'rxjs';
import { map, catchError } from 'rxjs/operators';
// Back for Backend
interface myData {
  success:boolean,
  message:string,
  obj:any
}
@Injectable({
  providedIn: 'root'
})
export class DeparturesWarehouseService {
  baseUrl="http://localhost:8080/goods-services/api/" // PC
  //baseUrl="http://localhost/goods-services/api/"; //LAPTOP
  //baseUrl="http://www.hempmex.com/goods-services/api/" // Hemp
  constructor(private http: HttpClient) { }  
  responce:any;


  getAllELemets(type:string, subtype:string){
    let params = (type == 'all_entries' ) ? "type="+type+"&subType="+subtype : "type="+type;
    return this.http.get(`${this.baseUrl}controller/entradas/getControllerEntries.php?`+params).pipe(
      map((res) => {
        this.responce = res;
        return this.responce;
    }),
    catchError(this.handleError));
  }


  private handleError(error: HttpErrorResponse) {
    console.log(error);
    return _throw('Error! something went wrong.');
  }
  


}
