<?php

namespace App\Transformers;

use App\ShopifyStore;
use League\Fractal\TransformerAbstract;

/**
 * Class ShopifyStoreTransformer
 * @package App\Transformers
 */
class ShopifyStoreTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [];

    /**
     * A Fractal transformer.
     *
     * @param ShopifyStore $shopifyStore
     * @return array
     */
    public function transform(ShopifyStore $shopifyStore)
    {
        return [
            'id' => $shopifyStore->id,
            'name' => $shopifyStore->name,
            'domain' => $shopifyStore->domain,
            'created_at' => $shopifyStore->created_at,
            'updated_at' => $shopifyStore->updated_at
        ];
    }
}
