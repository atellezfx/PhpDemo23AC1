import { Component, OnInit } from '@angular/core';
import { LoginService } from './services/login.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent implements OnInit {
  tituloApp = 'DogtorPET';

  constructor( public loginSvc:LoginService, private router:Router ) { }

  public ngOnInit(): void {
      if( !this.loginSvc.loggedIn() ) {
        this.router.navigateByUrl('/login');
      }
  }

  public cerrarSesion(): void {
    this.loginSvc.logout();
  }

}
