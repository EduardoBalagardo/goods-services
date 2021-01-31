import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse,  HttpHeaders } from '@angular/common/http';
import { _throw } from 'rxjs/Observable/throw';
import { Observable } from 'rxjs';
import { map, catchError } from 'rxjs/operators';

interface myData {
  success:boolean,
  message:string,
  session:any,
  obj:any
}

@Injectable({
  providedIn: 'root'
})
export class CatalogsService {
  responce:any;
  baseUrl="http://localhost:8080/goods-services/api/" // PC
  //baseUrl="http://localhost/goods-services/api/"; //LAPTOP
  //baseUrl="http://www.hempmex.com/goods-services/api/" // Hemp
  constructor(private http: HttpClient) { }

  getCentroCostos(){
    return this.http.get(`${this.baseUrl}controller/catalogs/getCatalogsController.php?type=centrocostos`).pipe(
      map((res) => {
        this.responce = res;
        return this.responce;
    }),
    catchError(this.handleError));
  }
  getProfileUser(){
    return this.http.get(`${this.baseUrl}controller/catalogs/getCatalogsController.php?type=profile`).pipe(
      map((res) => {
        this.responce = res;
        return this.responce;
    }),
    catchError(this.handleError));
  }
  getPuestos(){
    return this.http.get(`${this.baseUrl}controller/catalogs/getCatalogsController.php?type=puestos`).pipe(
      map((res) => {
        this.responce = res;
        return this.responce;
    }),
    catchError(this.handleError));
  }
  getRubroPresupuestal(){
    return this.http.get(`${this.baseUrl}controller/catalogs/getCatalogsController.php?type=rubropresupuesto`).pipe(
      map((res) => {
        this.responce = res;
        return this.responce;
    }),
    catchError(this.handleError));
  }

  getAnyCatalogs(type:string){
    return this.http.get(`${this.baseUrl}controller/catalogs/getCatalogsController.php?type=`+type).pipe(
      map((res) => {
        this.responce = res;
        return this.responce;
    }),
    catchError(this.handleError));
  }

  private handleError(error: HttpErrorResponse) {
    return _throw('Error! something went wrong.');
  }


}
