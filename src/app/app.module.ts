import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { RouterModule } from "@angular/router";
import { AppComponent } from './app.component';
import { NavBarComponent } from './components/nav-bar/nav-bar.component';
import { UserLoginComponent } from './components/user-login/user-login.component';
import { AuthGuard } from './auth.guard';
import { FormsModule, ReactiveFormsModule } from "@angular/forms";
import { HttpClientModule } from "@angular/common/http";
import { PurchaseOrderComponent } from './components/purchase-order/purchase-order.component';
import { AutotizacionesComponent } from './components/autotizaciones/autotizaciones.component';
import { QuatationsComponent } from './components/quatations/quatations.component';
import { PdfViewerModule } from 'ng2-pdf-viewer';
import { ReceptionGoodsComponent } from './components/reception-goods/reception-goods.component';
import { DeparturesWarehouseComponent } from './components/departures-warehouse/departures-warehouse.component';




@NgModule({
  declarations: [
    AppComponent,
    NavBarComponent,
    UserLoginComponent,
    PurchaseOrderComponent,
    AutotizacionesComponent,
    QuatationsComponent,
    ReceptionGoodsComponent,
    DeparturesWarehouseComponent,
],
  imports: [
    BrowserModule,
    FormsModule,
    ReactiveFormsModule,
    HttpClientModule,
    PdfViewerModule,
   
    RouterModule.forRoot([
      {path: 'user-login',     component: UserLoginComponent},
      {path: 'purchase-order', component: PurchaseOrderComponent},
      {path: 'autorizations',  component: AutotizacionesComponent},
      {path: 'quatations',     component: QuatationsComponent},
      {path: 'main-view',      component: NavBarComponent},
      {path: 'reception-goods',      component: ReceptionGoodsComponent },    
      {path: 'departures-warehouse',      component: DeparturesWarehouseComponent },      
      {path: '',               pathMatch: 'full', redirectTo:'user-login'}
    ], {useHash: true}),
  ],
  providers: [AuthGuard],
  bootstrap: [AppComponent]
})
export class AppModule { }
