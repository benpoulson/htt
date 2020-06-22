import { Injectable } from '@angular/core';
import { EntityState, EntityStore, StoreConfig } from '@datorama/akita';
import { Store } from './store.model';

export interface StoresState extends EntityState<Store> {}

@Injectable({ providedIn: 'root' })
@StoreConfig({ name: 'stores' })
export class StoresStore extends EntityStore<StoresState> {

  constructor() {
    super();
  }

}
