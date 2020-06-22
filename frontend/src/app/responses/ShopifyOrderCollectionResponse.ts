import {ShopifyStore} from "../interfaces/ShopifyStore";
import {Order} from "../state/order.model";

export interface ShopifyOrderCollectionResponse {
    data: Order[]
}
