<?php

namespace App\Http\Controllers\Shopify;

use App\Http\Controllers\Controller;
use App\ShopifyStore;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;

/**
 * Class ShopifyOrderController
 * @package App\Http\Controllers
 */
class OrderController extends Controller
{
    /**
     * @param ShopifyStore $shopifyStore
     * @param Request $request
     * @return array
     * @throws GuzzleException
     */
    public function list(ShopifyStore $shopifyStore, Request $request)
    {

        $limit = $request->get('limit', 5);
        $pageInfo = $request->get('page_info');

        $params = ['limit' => $limit];

        if ($pageInfo) {
            $params['page_info'] = $pageInfo;
            unset($params['limit']); // One or the other, not both
        }

        return $shopifyStore->getRestClient()->allOrders($params);
    }

    public function view(ShopifyStore $shopifyStore, int $orderId)
    {
        return $shopifyStore->getGraphQLClient()->order()->get($orderId);
    }
}
