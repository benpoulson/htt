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

@NgModule({
    declarations: [
        AppComponent,
        LoginComponent,
        StoresComponent
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
    ],
    providers: [],
    bootstrap: [AppComponent]
})
export class AppModule {
}
