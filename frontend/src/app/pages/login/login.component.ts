import {Component, OnInit} from '@angular/core';
import {ApiClientService} from "../../services/api-client.service";
import {JWTResponse} from "../../interfaces/JWTResponse";
import {Router} from "@angular/router"
import * as moment from "moment";

@Component({
    selector: 'app-login',
    templateUrl: './login.component.html',
    styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {

    public email;
    public password;

    constructor(private api: ApiClientService, private router: Router) {
    }

    ngOnInit(): void {

    }

    public login() {
        this.api.login(this.email, this.password).subscribe((data: JWTResponse) => {
            localStorage.setItem("access_token", data.access_token);
            localStorage.setItem("access_expires", moment().add(data.expires_in, "seconds").toISOString());
            this.router.navigate(['stores'])
        }, (error => {
            alert("Invalid Email or Password")
        }));
    }

}
