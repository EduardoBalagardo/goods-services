import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse,  HttpHeaders } from '@angular/common/http';
import { _throw } from 'rxjs/Observable/throw';
import { Observable } from 'rxjs';
import { map, catchError } from 'rxjs/operators';

interface myData {
  success:boolean,
  message:string,
  session:any,
  user:any
}

@Injectable({
  providedIn: 'root'
})

 //baseUrl = "http://189.254.76.148/moo/api/";
 //Tesci1!
 //123456

export class AuthService {
  loggedInStauts = JSON.parse(localStorage.getItem('uid') || 'false');
  baseUrl="http://localhost:8080/goods-services/api/" // PC
  //baseUrl="http://localhost/goods-services/api/"; //LAPTOP
  //baseUrl="http://www.hempmex.com/goods-services/api/" // Hemp
  userObj:any;
  constructor(private http: HttpClient) { }

  postTokenAcces(user:any): Observable<myData> {
    return this.http.post(`${this.baseUrl}session/authController.php`,{user:user.user, pass:user.pass}).pipe(
      map((res: myData) => {
        this.userObj = res;
        return this.userObj;
      }),
      catchError(this.handleError));
  }

  setLoggedIn(value:boolean){
    this.loggedInStauts = value;
    localStorage.setItem('uid','true');
  }

  get isLoggedIn(){
    return JSON.parse(localStorage.getItem('uid') || this.loggedInStauts );
  }


  getChekSession(){
    return this.http.get<myData>(`${this.baseUrl}session/chekCookieController.php`).pipe(
      map((res: myData) => {
        this.userObj = res;
        return this.userObj;
      }),
      catchError(this.handleError));
  }

  destroySession(){
    return this.http.get<myData>(`${this.baseUrl}session/deleteCookieController.php`).pipe(
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
