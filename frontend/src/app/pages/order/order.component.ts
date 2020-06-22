import { Component, OnInit } from '@angular/core';
import {Observable} from "rxjs";
import {Store} from "../../state/store.model";
import {StoresService} from "../../state/stores.service";
import {StoresQuery} from "../../state/stores.query";
import {Order} from "../../state/order.model";
import {OrdersService} from "../../state/orders.service";
import {OrdersQuery} from "../../state/orders.query";
import {ActivatedRoute} from "@angular/router";

@Component({
  selector: 'app-order',
  templateUrl: './order.component.html',
  styleUrls: ['./order.component.scss']
})
export class OrderComponent implements OnInit {

    order$?: Observable<Order>;
    storeId: number;
    orderId: number;

    public constructor(private route: ActivatedRoute, private ordersService: OrdersService, private ordersQuery: OrdersQuery) {
        this.storeId = this.route.snapshot.params.storeId;
        this.orderId = this.route.snapshot.params.orderId;
    }

    ngOnInit(): void {

        if (this.ordersQuery.hasEntity(this.orderId) === false) {
            this.ordersService.getOrder(this.storeId, this.orderId)
        }

        this.order$ = this.ordersQuery.selectEntity(this.orderId);
    }

}
