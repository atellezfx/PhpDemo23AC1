import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { EliminarComponent } from './components/eliminar/eliminar.component';
import { EditarComponent } from './components/editar/editar.component';
import { LoginComponent } from './components/login/login.component';
import { AgregarComponent } from './components/agregar/agregar.component';
import { CatalogoComponent } from './components/catalogo/catalogo.component';
import { LoginGuard } from './util/login.guard';

const routes: Routes = [
  { path: '', redirectTo: '/catalogo', pathMatch: 'full' },
  { path: 'login', component: LoginComponent },
  { path: 'catalogo', component: CatalogoComponent, canActivate: [LoginGuard] },
  { path: 'nuevo', component: AgregarComponent, canActivate: [LoginGuard] },
  { path: 'editar/:id', component: EditarComponent, canActivate: [LoginGuard] },
  { path: 'eliminar/:id', component: EliminarComponent, canActivate: [LoginGuard] }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
