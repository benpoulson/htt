import {Component, OnInit} from '@angular/core';
import {StoresService} from "../../state/stores.service";
import {StoresQuery} from "../../state/stores.query";
import {Observable} from "rxjs";
import {Store} from "../../state/store.model";

@Component({
    selector: 'app-stores',
    templateUrl: './stores.component.html',
    styleUrls: ['./stores.component.scss']
})
export class StoresComponent implements OnInit {

    list$?: Observable<Store[]>;

    public constructor(private storesService: StoresService, private storesQuery: StoresQuery) {

    }

    ngOnInit(): void {
        this.storesService.getStores()
        this.list$ = this.storesQuery.selectAll();
    }

}
