<?php

namespace Tests\Feature;

use App\ShopifyStore;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * Class ShopifyStoreFeatureTest
 * Tests specifically relating to the Shopify endpoints
 * @package Tests\Feature
 */
class ShopifyStoreFeatureTest extends TestCase
{
    use DatabaseTransactions;

    public function testAccessShopifyListingEndpoint()
    {
        $user = $this->createLoggedInUser();
        $response = $this->actingAs($user)->get(route('shopify.list', [], false));
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'domain',
                    'created_at',
                    'updated_at'
                ]
            ]
        ]);
        $response->assertDontSeeText("api_key");
        $response->assertDontSeeText("password");
        $response->assertDontSeeText("shared_secret");
    }

    public function testAccessShopifyViewEndpoint()
    {
        $user = $this->createLoggedInUser();
        $response = $this->actingAs($user)->get(route('shopify.view', ['shopifyStore' => ShopifyStore::first()], false));
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'domain',
                'created_at',
                'updated_at'
            ]
        ]);
        $response->assertDontSeeText("api_key");
        $response->assertDontSeeText("password");
        $response->assertDontSeeText("shared_secret");
    }

    public function testAccessShopifyUpdateEndpoint()
    {
        $user = $this->createLoggedInUser();
        $response = $this->actingAs($user)->post(route('shopify.update', ['shopifyStore' => ShopifyStore::first()], false), ['name' => 'Test Store']);
        $response->assertJsonFragment(['name' => 'Test Store']);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'domain',
                'created_at',
                'updated_at'
            ]
        ]);
        $response->assertDontSeeText("api_key");
        $response->assertDontSeeText("password");
        $response->assertDontSeeText("shared_secret");
    }

    public function testAccessShopifyCreateEndpoint()
    {
        $user = $this->createLoggedInUser();
        $response = $this->actingAs($user)->post(route('shopify.create', [], false), [
            'name' => 'Test Store',
            'domain' => 'demo.shopify.com',
            'api_key' => 'abc123',
            'password' => 'abc123',
            'shared_secret' => 'abc123',
        ]);
        $response->assertJsonFragment(['name' => 'Test Store']);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'domain',
                'created_at',
                'updated_at'
            ]
        ]);
        $response->assertDontSeeText("api_key");
        $response->assertDontSeeText("password");
        $response->assertDontSeeText("shared_secret");
    }

    public function testAccessShopifyDeleteEndpoint()
    {
        $user = $this->createLoggedInUser();
        $store = ShopifyStore::first();
        $response = $this->actingAs($user)->delete(route('shopify.delete', ['shopifyStore' => $store], false));
        $response->assertJsonFragment(['acknowledged' => true]);
        $this->assertFalse($store->exists());
    }

}
