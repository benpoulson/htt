import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {environment} from '../../environments/environment';
import {JWTResponse} from "../interfaces/JWTResponse";
import {Observable} from "rxjs";

@Injectable({
    providedIn: 'root'
})
export class ApiClientService {

    constructor(private http: HttpClient) {
    }

    public login(email: string, password: string): Observable<JWTResponse> {
        return this.http.post<JWTResponse>(environment.api_base + "/auth/login", {
            email,
            password
        });
    }

    public refresh() {
        return this.http.post<JWTResponse>(environment.api_base + "/auth/refresh", null);
    }

    public getStores() {
        return this.http.get(environment.api_base + "/shopify");
    }

}
