import { Component, OnInit } from '@angular/core';
import {ApiClientService} from "../../services/api-client.service";

@Component({
  selector: 'app-stores',
  templateUrl: './stores.component.html',
  styleUrls: ['./stores.component.scss']
})
export class StoresComponent implements OnInit {

    public constructor(private api: ApiClientService) {

    }

  public stores = [];

  ngOnInit(): void {
      this.api.getStores().subscribe((data: any) => {
          this.stores = data.data;
      })
  }

}
