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
export class PurchaseOrderService {
  responce:any;
  baseUrl="http://localhost:8080/goods-services/api/" // PC
  //baseUrl="http://localhost/goods-services/api/"; //LAPTOP
  //baseUrl="http://www.hempmex.com/goods-services/api/" // Hemp


  constructor(private http: HttpClient) { }
  userObj:any;
 
  postPurchaseOrde(purchaseOrder:any): Observable<myData> {
      return this.http.post(`${this.baseUrl}controller/purchase/postControllerPurchase.php`,{purchaseOrder:purchaseOrder}).pipe(
        map((res: myData) => {
          this.userObj = res;
          return this.userObj;
        }),
        catchError(this.handleError));
    }

    postPurchaseDetail(purchaseDetail:any):Observable<myData>{
      return this.http.post(`${this.baseUrl}controller/purchase/postControllerPurchase.php`,{purchaseDetail:purchaseDetail}).pipe(
        map((res: myData) => {
          this.userObj = res;
          return this.userObj;
        }),
        catchError(this.handleError));
    }

    postPurchaseAutorizes(obj:any):Observable<myData>{
      return this.http.post(`${this.baseUrl}controller/purchase/postControllerPurchase.php`,{purchaseAutorized:obj}).pipe(
        map((res: myData) => {
          this.userObj = res;
          console.log(this.userObj);
          return this.userObj;
        }),
        catchError(this.handleError));
    }

    getAllELemets(type:string, subtype:string){
    let params = (type == 'autorization_list' ) ? "type="+type+"&subType="+subtype : "type="+type;
    return this.http.get(`${this.baseUrl}controller/purchase/getControllerPurchase.php?`+params).pipe(
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
