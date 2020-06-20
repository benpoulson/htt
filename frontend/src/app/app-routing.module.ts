import {NgModule} from '@angular/core';
import {RouterModule, Routes} from '@angular/router';
import {StoresComponent} from "./pages/stores/stores.component";
import {LoginComponent} from "./pages/login/login.component";


const routes: Routes = [
    {path: 'login', component: LoginComponent},
    {path: 'stores', component: StoresComponent},
    {path: 'stores/:storeId', component: StoresComponent},
    {path: 'stores/:storeId/orders', component: StoresComponent},
    {path: 'stores/:storeId/orders/:orderId', component: StoresComponent},
    {path: '', redirectTo: '/login', pathMatch: 'full'},
    {path: '**', component: StoresComponent}
];

@NgModule({
    imports: [RouterModule.forRoot(routes)],
    exports: [RouterModule]
})
export class AppRoutingModule {
}
