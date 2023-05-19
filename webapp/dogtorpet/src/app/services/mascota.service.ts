import { Injectable } from '@angular/core';
import { Observable, of } from 'rxjs';
import { Mascota } from '../models/mascota';
import { mascotasPrueba } from '../models/datos-prueba';

@Injectable({
  providedIn: 'root'
})
export class MascotaService {

  // TODO: Implementar URL de conexión con el backend (Servidor)

  constructor() { }

  public obtener( id:number ): Observable<Mascota> {
    // Código que se simplificará al comunicarse con el servidor
    const result = mascotasPrueba.filter( m => m.id == id  );
    return of( result[0] );
  }

  public lista( propietario:string ): Observable<Mascota[]> {
    const result = mascotasPrueba.filter( m => m.propietario == propietario  );
    return of( result );
  }

  public insertar( m:Mascota ): Observable<Mascota> {
    // TODO: Implementar el proceso de inserción en el backend
    console.log(`Insertando registro de: ${m.nombre}`);
    return of( m );
  }

  public editar( m:Mascota ): Observable<Mascota> {
    // TODO: Implementar el proceso de edición en el backend
    console.log(`Editando registro de: ${m.nombre}`);
    return of( m );
  }

  public eliminar( m:Mascota ): Observable<Mascota> {
    // TODO: Implementar el proceso de eliminación en el backend
    console.log(`Eliminando registro de: ${m.nombre}`);
    return of( m );
  }


}
