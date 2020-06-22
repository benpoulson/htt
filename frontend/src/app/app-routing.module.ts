import {NgModule} from '@angular/core';
import {RouterModule, Routes} from '@angular/router';
import {StoresComponent} from "./pages/stores/stores.component";
import {LoginComponent} from "./pages/login/login.component";
import {ManageComponent} from "./pages/manage/manage.component";
import {OrderComponent} from "./pages/order/order.component";
import {OrderListComponent} from "./pages/order-list/order-list.component";


const routes: Routes = [
    {path: 'login', component: LoginComponent},
    {path: 'stores', component: StoresComponent},
    {path: 'stores/:storeId', component: ManageComponent},
    {path: 'stores/:storeId/orders', component: OrderListComponent},
    {path: 'stores/:storeId/orders/:orderId', component: OrderComponent},
    {path: '', redirectTo: '/login', pathMatch: 'full'},
    {path: '**', component: StoresComponent}
];

@NgModule({
    imports: [RouterModule.forRoot(routes)],
    exports: [RouterModule]
})
export class AppRoutingModule {
}
