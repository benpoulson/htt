import {Injectable} from '@angular/core';
import {NgEntityService} from '@datorama/akita-ng-entity-service';
import {OrdersState, OrdersStore} from './orders.store';
import {environment} from "../../environments/environment";
import {catchError} from "rxjs/operators";
import {HttpErrorResponse} from "@angular/common/http";
import {throwError} from "rxjs";
import {Order} from "./order.model";

@Injectable({providedIn: 'root'})
export class OrdersService extends NgEntityService<OrdersState> {

    constructor(protected store: OrdersStore) {
        super(store);
    }

    getOrders(storeId: number, sinceId: number): void {
        this.getHttp().get<Order[]>(`${environment.api_base}/shopify/${storeId}/order/?since=${sinceId}`)
            .pipe(
                catchError((error: HttpErrorResponse) => {
                    alert(error.message);
                    return throwError(error.message);
                })
            )
            .subscribe(response => {this.store.set(response)});
    }

    getOrder(storeId: number, orderId: number): void {
        this.getHttp().get<Order>(`${environment.api_base}/shopify/${storeId}/order/${orderId}`)
            .pipe(
                catchError((error: HttpErrorResponse) => {
                    alert(error.message);
                    return throwError(error.message);
                })
            )
            .subscribe(response => {
                this.store.add(response);
                console.log(response)
            });
    }

}
