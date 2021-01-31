import { Component, OnInit } from '@angular/core';
import { AuthService } from '../../services/auth.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-nav-bar',
  templateUrl: './nav-bar.component.html',
  styleUrls: ['./nav-bar.component.css']
})
export class NavBarComponent implements OnInit {

  constructor(private auth:AuthService, private router:Router) { }

  ngOnInit() {
    if(!this.auth.userObj){
      localStorage.removeItem('uid');
      this.auth.loggedInStauts = false;
      this.router.navigate(['user-login']);
    }
  }

  clearSession(){
    this.auth.destroySession().subscribe(res=>{
      this.auth.userObj.user = null;
      localStorage.removeItem('uid');
      this.auth.loggedInStauts = false;
      this.router.navigate(['user-login']);
    });
  }

}
