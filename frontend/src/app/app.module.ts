import {BrowserModule} from '@angular/platform-browser';
import {NgModule} from '@angular/core';
import {TooltipModule} from 'ngx-bootstrap/tooltip';

import {AppRoutingModule} from './app-routing.module';
import {AppComponent} from './app.component';
import {JwtModule} from "@auth0/angular-jwt";
import {HttpClientModule} from "@angular/common/http";
import {LoginComponent} from './pages/login/login.component';
import {StoresComponent} from './pages/stores/stores.component';
import {FormsModule} from "@angular/forms";
import {ApiClientService} from "./services/api-client.service";
import { ManageComponent } from './pages/manage/manage.component';
import { NG_ENTITY_SERVICE_CONFIG } from '@datorama/akita-ng-entity-service';
import { AkitaNgDevtools } from '@datorama/akita-ngdevtools';
import { AkitaNgRouterStoreModule } from '@datorama/akita-ng-router-store';
import { environment } from '../environments/environment';
import { OrderComponent } from './pages/order/order.component';
import { OrderListComponent } from './pages/order-list/order-list.component';

@NgModule({
    declarations: [
        AppComponent,
        LoginComponent,
        StoresComponent,
        ManageComponent,
        OrderComponent,
        OrderListComponent
    ],
    imports: [
        BrowserModule,
        HttpClientModule,
        AppRoutingModule,
        FormsModule,
        JwtModule.forRoot({
            config: {
                tokenGetter: (request) => {
                    return localStorage.getItem("access_token");
                },
            },
        }),
        TooltipModule.forRoot(),
        environment.production ? [] : AkitaNgDevtools.forRoot(),
        AkitaNgRouterStoreModule,
    ],
    providers: [{ provide: NG_ENTITY_SERVICE_CONFIG, useValue: { baseUrl: 'https://jsonplaceholder.typicode.com' }}],
    bootstrap: [AppComponent]
})
export class AppModule {
}
