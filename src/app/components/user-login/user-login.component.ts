import { Component, OnInit } from '@angular/core';
import { AuthService } from '../../services/auth.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-user-login',
  templateUrl: './user-login.component.html',
  styleUrls: ['./user-login.component.css']
})
export class UserLoginComponent implements OnInit {
  user:any={user:"",pass:""};
  isSuccess:boolean=true;
  constructor(private aut:AuthService,private router:Router) {

  }


  ngOnInit() {
  }
    /**
   * @name        getUserLogin
   * @description This function call postTokenAcces that go to auth back office //authController
   * @params      By asigned on flow
   * @return      observer.
   * **/
  getUserLogin(){
    if( (this.user.user != '' || this.user.user != null ) &&  ( this.user.pass!= '' || this.user.pas != null ) )
    {
      this.aut.postTokenAcces(this.user).subscribe(
        res => {          
          if(res.success){
            this.isSuccess = res.success;
            this.router.navigate(['main-view'])
            this.aut.setLoggedIn(res.success);
          } else {
            this.isSuccess = res.success;
          }
        },
        err => { console.log(err.message);
        });
    } else {
      this.isSuccess = false;
    }

  }

}
