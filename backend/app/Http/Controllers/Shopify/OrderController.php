<?php

namespace App\Http\Controllers\Shopify;

use App\Http\Controllers\Controller;
use App\ShopifyStore;

/**
 * Class ShopifyOrderController
 * @package App\Http\Controllers
 */
class OrderController extends Controller
{
    public function view(ShopifyStore $shopifyStore, int $orderId)
    {
        return $shopifyStore->getService()->order()->get($orderId);
    }
}
