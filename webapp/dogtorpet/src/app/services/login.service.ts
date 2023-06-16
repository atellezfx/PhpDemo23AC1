import { Injectable } from '@angular/core';
import { Router } from '@angular/router';
import { Observable} from 'rxjs';

import { Usuario } from '../models/usuario';
import { Token } from '../models/token';
import { Mensaje } from '../models/mensaje';
import { environment } from 'src/environments/environment';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class LoginService {

  private readonly servidor = `${environment.urlServidor}/login`;

  // Angular inyectará la dependencia del Router y del cliente de HTTP
  constructor( private router:Router, private client:HttpClient ) { }

  public login( usr:Usuario ): Observable<Token|Mensaje> {
    return this.client.post<Token|Mensaje>(this.servidor, usr);
  }

  public logout():void {
    localStorage.clear();
    this.router.navigateByUrl('/login');
  }

  public usuarioActual(): string|null {
    return localStorage.getItem(environment.usuarioActual);
  }

  public loggedIn(): boolean {
    return !!this.usuarioActual();
  }

}
