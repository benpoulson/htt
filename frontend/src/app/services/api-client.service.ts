import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {environment} from '../../environments/environment';
import {JWTLoginResponse} from "../interfaces/JWTLoginResponse";
import {Observable} from "rxjs";
import {ShopifyStoreCollectionResponse} from "../responses/ShopifyStoreCollection";

@Injectable({
    providedIn: 'root'
})
export class ApiClientService {

    constructor(private http: HttpClient) {
    }

    public login(email: string, password: string): Observable<JWTLoginResponse> {
        return this.http.post<JWTLoginResponse>(environment.api_base + "/auth/login", {
            email,
            password
        });
    }

    public refresh() {
        return this.http.post<JWTLoginResponse>(environment.api_base + "/auth/refresh", null);
    }

    public getStores() {
        return this.http.get<ShopifyStoreCollectionResponse>(environment.api_base + "/shopify");
    }

}
