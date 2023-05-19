import { Component } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { Router } from '@angular/router';
import { LoginService } from 'src/app/services/login.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent {

  formulario:FormGroup;
  mensajeError:string = '';

  constructor( private builder:FormBuilder, private loginSvc:LoginService, private router:Router ) {
    this.formulario = builder.group({ username:[''], password:[''] });
  }

  public enviarDatos():void {
    this.loginSvc.login( this.formulario.value ).subscribe({
      next: datos => this.router.navigateByUrl('/catalogo'),
      error: datos => this.mensajeError = datos
    });
  }

}
