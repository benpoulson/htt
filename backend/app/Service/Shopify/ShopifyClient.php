<?php

namespace App\Service\Shopify;

use App\ShopifyStore;

/**
 * Class ShopifyClient
 * @package App\Service\Shopify
 */
abstract class ShopifyClient
{

    private ShopifyStore $store;

    public function __construct(ShopifyStore $store)
    {
        $this->store = $store;
    }

    protected function getApiDomain()
    {
        return sprintf('https://%s/admin/api/%s/', $this->store->domain, config('shopify.api_version'));
    }

    protected function getAuthorizationHeaderValue()
    {
        $authorization = base64_encode(sprintf('%s:%s', $this->store->api_key, $this->store->password));
        return sprintf('Basic %s', $authorization);
    }
}
