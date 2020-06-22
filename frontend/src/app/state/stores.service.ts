import {Injectable} from '@angular/core';
import {NgEntityService} from '@datorama/akita-ng-entity-service';
import {StoresState, StoresStore} from './stores.store';
import {environment} from '../../environments/environment';
import {HttpErrorResponse} from "@angular/common/http";
import {catchError} from "rxjs/operators";
import {throwError} from "rxjs";
import {ShopifyStoreResponse} from "../responses/ShopifyStoreResponse";
import {ShopifyStoreCollectionResponse} from "../responses/ShopifyStoreCollectionResponse";

@Injectable({providedIn: 'root'})
export class StoresService extends NgEntityService<StoresState> {

    constructor(protected store: StoresStore) {
        super(store);
    }

    getStores(): void {
        this.getHttp().get<ShopifyStoreCollectionResponse>(`${environment.api_base}/shopify`)
            .pipe(
                catchError((error: HttpErrorResponse) => {
                    alert(error.message);
                    return throwError(error.message);
                })
            )
            .subscribe(response => this.store.set(response.data));
    }

    getStore(id: string): void {
        this.getHttp().get<ShopifyStoreResponse>(`${environment.api_base}/shopify/${id}`)
            .pipe(
                catchError((error: HttpErrorResponse) => {
                    alert(error.message);
                    return throwError(error.message);
                })
            )
            .subscribe(response => this.store.add(response.data));
    }

}
