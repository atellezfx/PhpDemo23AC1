import { Injectable } from '@angular/core';
import { Router } from '@angular/router';
import { Observable, of, throwError } from 'rxjs';

import { Usuario } from '../models/usuario';
import { usuariosPrueba } from '../models/datos-prueba';

@Injectable({
  providedIn: 'root'
})
export class LoginService {

  // TODO: Implementar la URL de conexión al backend (servidor)

  // Angular inyectará la dependencia del Router
  constructor( private router:Router ) { }

  public login( usr:{username:string, password:string} ): Observable<Usuario> {
    // TODO: Implementar login a través del backend
    const result = usuariosPrueba.filter( u => u.username == usr.username  )[0];
    if( result && result.password == usr.password ) {
      // Usuario autenticado exitosamente
      localStorage.setItem('usuarioActual', usr.username);
      return of( result );
    } else {
      return throwError( () => new Error('Credenciales incorrectas') );
    }
  }

  public logout():void {
    localStorage.clear();
    this.router.navigateByUrl('/login');
  }

  public usuarioActual(): string|null {
    return localStorage.getItem('usuarioActual');
  }

  public loggedIn(): boolean {
    return !!this.usuarioActual();
  }

}
