<?php

namespace App\Http\Controllers\Shopify;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShopifyStoreCreateRequest;
use App\ShopifyStore;
use App\Transformers\ShopifyStoreTransformer;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class ShopifyStoreController
 * @package App\Http\Controllers
 */
class StoreController extends Controller
{
    /**
     * Lists the stores
     * @return JsonResponse
     */
    public function list()
    {
        return fractal(ShopifyStore::all(), new ShopifyStoreTransformer())->respond();
    }

    /**
     * Creates a new store
     * @param ShopifyStoreCreateRequest $request
     * @return JsonResponse
     */
    public function create(ShopifyStoreCreateRequest $request)
    {
        $shopifyStore = ShopifyStore::create($request->all());
        return fractal($shopifyStore, new ShopifyStoreTransformer())->respond();
    }

    /**
     * Gets the data for the specific store
     * @param ShopifyStore $shopifyStore
     * @return JsonResponse
     */
    public function view(ShopifyStore $shopifyStore)
    {
        return fractal($shopifyStore, new ShopifyStoreTransformer())->respond();
    }

    /**
     * Update the store
     * @param Request $request
     * @param ShopifyStore $shopifyStore
     * @return JsonResponse
     */
    public function update(Request $request, ShopifyStore $shopifyStore)
    {
        $shopifyStore->update($request->all());
        return fractal($shopifyStore, new ShopifyStoreTransformer())->respond();
    }

    /**
     * Deletes the chosen store
     * @param ShopifyStore $shopifyStore
     * @return JsonResponse
     * @throws Exception
     */
    public function delete(ShopifyStore $shopifyStore)
    {
        return response()->json([
            'data' => [
                'acknowledged' => $shopifyStore->delete()
            ]
        ]);
    }
}
