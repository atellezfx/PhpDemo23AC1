import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { Mascota } from '../models/mascota';
import { environment } from 'src/environments/environment';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class MascotaService {

  private readonly servidor = `${environment.urlServidor}/mascota`;

  constructor( private cliente:HttpClient ) { }

  public obtener( id:number ): Observable<Mascota> {
    return this.cliente.get<Mascota>(`${this.servidor}/${id}`);
  }

  public lista( propietario:string ): Observable<Mascota[]> {
    return this.cliente.get<Mascota[]>(`${this.servidor}/catalogo/${propietario}`);
  }

  public insertar( m:Mascota ): Observable<Mascota> {
    // console.log(`Insertando registro de: ${m.nombre}`);
    return this.cliente.post<Mascota>(this.servidor, m);
  }

  public editar( m:Mascota ): Observable<Mascota> {
    // console.log(`Editando registro de: ${m.nombre}`);
    return this.cliente.put<Mascota>(`${this.servidor}/${m.id}`, m);
  }

  public eliminar( m:Mascota ): Observable<Mascota> {
    // console.log(`Eliminando registro de: ${m.nombre}`);
    return this.cliente.delete<Mascota>(`${this.servidor}/${m.id}`);
  }


}
