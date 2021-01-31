import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse,  HttpHeaders } from '@angular/common/http';
import { _throw } from 'rxjs/Observable/throw';
import { Observable } from 'rxjs';
import { map, catchError } from 'rxjs/operators';

interface myData {success:boolean,message:string,obj:any}

@Injectable({
  providedIn: 'root'
})
export class ContractualService {
  responce:any;
  userObj:any;
  baseUrl="http://localhost:8080/goods-services/api/" // PC
  //baseUrl="http://localhost/goods-services/api/"; //LAPTOP
  //baseUrl="http://www.hempmex.com/goods-services/api/" // Hemp
  constructor(private http: HttpClient) { }

  getAllELemets(type:string, subtype:string){
    let params = (type == 'contractual_order' ) ? "type="+type+"&subType="+subtype : "type="+type;
    return this.http.get(`${this.baseUrl}controller/contractual/getControllerContractual.php?`+params).pipe(
      map((res) => {
        this.responce = res;
        return this.responce;
    }),
    catchError(this.handleError));
  }

  postAll(cOrdDetail:any):Observable<myData>{
    return this.http.post(`${this.baseUrl}controller/contractual/postControllerContractual.php`,{cOrdDetail:cOrdDetail}).pipe(
      map((res: myData) => {
        this.userObj = res;
        return this.userObj;
      }),
      catchError(this.handleError));
  }


  private handleError(error: HttpErrorResponse) {
    console.log(error);
    return _throw('Error! something went wrong.');
  }
}
