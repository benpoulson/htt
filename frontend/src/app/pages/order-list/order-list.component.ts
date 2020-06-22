import {Component, OnInit} from '@angular/core';
import {ActivatedRoute} from "@angular/router";
import {OrdersService} from "../../state/orders.service";
import {OrdersQuery} from "../../state/orders.query";
import {Observable} from "rxjs";
import {Order} from "../../state/order.model";

@Component({
    selector: 'app-order-list',
    templateUrl: './order-list.component.html',
    styleUrls: ['./order-list.component.scss']
})
export class OrderListComponent implements OnInit {

    public storeId;
    public orders$: Observable<Order[]>;
    public currentPage = 1;

    public constructor(private route: ActivatedRoute, private ordersService: OrdersService, private ordersQuery: OrdersQuery) {
        this.storeId = this.route.snapshot.params.storeId;
    }

    ngOnInit(): void {
        this.loadOrders(this.storeId, null);
    }

    public loadOrders(storeId: number, sinceId: number) {
        this.ordersService.getOrders(storeId, sinceId);
        this.orders$ = this.ordersQuery.selectAll();
    }

    prevPage() {

    }

    nextPage() {
        loadOrders
    }
}
