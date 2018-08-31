import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

import { SharedModule } from '../shared/shared.module';
import { AppComponent } from './app.component';
import { HomeComponent } from './home/home.component';
import { NotFoundComponent } from './notfound/notfound.component';
import { GrafiekenModule } from '../grafieken/grafieken.module';
import { MeterstandenModule } from '../meterstanden/meterstanden.module';

@NgModule({
  declarations: [
    AppComponent,
    HomeComponent,
    NotFoundComponent
  ],
  imports: [
    SharedModule,
    GrafiekenModule,
    MeterstandenModule,
    RouterModule.forRoot([
      { path: 'home', component: HomeComponent },
      { path: '', redirectTo: 'home', pathMatch: 'full' },
      { path: '**', component: NotFoundComponent}
    ]),
    
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }