<?php

namespace App\Service;

use App\ShopifyStore;
use Shopify\Service\AbandonedCheckoutsService;
use Shopify\Service\ApplicationChargeService;
use Shopify\Service\ApplicationCreditService;
use Shopify\Service\ArticleService;
use Shopify\Service\AssetService;
use Shopify\Service\BlogService;
use Shopify\Service\CollectService;
use Shopify\Service\CommentService;
use Shopify\Service\CountryService;
use Shopify\Service\CustomCollectionService;
use Shopify\Service\CustomerAddressService;
use Shopify\Service\CustomerService;
use Shopify\Service\DiscountCodeService;
use Shopify\Service\EventService;
use Shopify\Service\FulfillmentEventService;
use Shopify\Service\FulfillmentService;
use Shopify\Service\GiftCardService;
use Shopify\Service\GraphQLService;
use Shopify\Service\LocationService;
use Shopify\Service\MarketingEventService;
use Shopify\Service\MetafieldService;
use Shopify\Service\OrderService;
use Shopify\Service\PageService;
use Shopify\Service\PolicyService;
use Shopify\Service\PriceRuleService;
use Shopify\Service\ProductImageService;
use Shopify\Service\ProductService;
use Shopify\Service\ProductVariantService;
use Shopify\Service\ProvinceService;
use Shopify\Service\RecurringApplicationChargeService;
use Shopify\Service\RedirectService;
use Shopify\Service\RefundService;
use Shopify\Service\ReportService;
use Shopify\Service\ScriptTagService;
use Shopify\Service\ShippingZoneService;
use Shopify\Service\ShopService;
use Shopify\Service\SmartCollectionService;
use Shopify\Service\ThemeService;
use Shopify\Service\TransactionService;
use Shopify\Service\UsageChargeService;
use Shopify\Service\UserService;
use Shopify\Service\WebhookService;

/**
 * Class ShopifyService
 * A wrapper class to integrate Laravel and the Shopify SDK together
 * @package App\Service
 */
class ShopifyService
{
    /** @var ShopifyStore */
    protected $shopifyStore;

    /** @var ShopifyApi */
    protected $client;

    /**
     * ShopifyService constructor.
     * @param ShopifyStore $shopifyStore
     */
    public function __construct(ShopifyStore $shopifyStore)
    {
        $this->shopifyStore = $shopifyStore;
        $this->client = new ShopifyApi([
            'api_version' => '2020-04/',
            'api_key' => $shopifyStore->api_key,
            'password' => $shopifyStore->password,
            'shared_secret' => $shopifyStore->shared_secret,
            'myshopify_domain' => $shopifyStore->domain
        ]);
    }

    /**
     * @return AbandonedCheckoutsService
     */
    public function abandonedCheckouts(): AbandonedCheckoutsService
    {
        return new AbandonedCheckoutsService($this->client);
    }

    /**
     * @return ApplicationChargeService
     */
    public function applicationCharge(): ApplicationChargeService
    {
        return new ApplicationChargeService($this->client);
    }

    /**
     * @return ApplicationCreditService
     */
    public function applicationCredit(): ApplicationCreditService
    {
        return new ApplicationCreditService($this->client);
    }

    /**
     * @return ArticleService
     */
    public function article(): ArticleService
    {
        return new ArticleService($this->client);
    }

    /**
     * @return AssetService
     */
    public function asset(): AssetService
    {
        return new AssetService($this->client);
    }

    /**
     * @return BlogService
     */
    public function blog(): BlogService
    {
        return new BlogService($this->client);
    }

    /**
     * @return CollectService
     */
    public function collect(): CollectService
    {
        return new CollectService($this->client);
    }

    /**
     * @return CommentService
     */
    public function comment(): CommentService
    {
        return new CommentService($this->client);
    }

    /**
     * @return CountryService
     */
    public function country(): CountryService
    {
        return new CountryService($this->client);
    }

    /**
     * @return CustomCollectionService
     */
    public function customCollection(): CustomCollectionService
    {
        return new CustomCollectionService($this->client);
    }

    /**
     * @return CustomerAddressService
     */
    public function customerAddress(): CustomerAddressService
    {
        return new CustomerAddressService($this->client);
    }

    /**
     * @return CustomerService
     */
    public function customer(): CustomerService
    {
        return new CustomerService($this->client);
    }

    /**
     * @return DiscountCodeService
     */
    public function discountCode(): DiscountCodeService
    {
        return new DiscountCodeService($this->client);
    }

    /**
     * @return EventService
     */
    public function event(): EventService
    {
        return new EventService($this->client);
    }

    /**
     * @return FulfillmentEventService
     */
    public function fulfillmentEvent(): FulfillmentEventService
    {
        return new FulfillmentEventService($this->client);
    }

    /**
     * @return FulfillmentService
     */
    public function fulfillment(): FulfillmentService
    {
        return new FulfillmentService($this->client);
    }

    /**
     * @return GiftCardService
     */
    public function giftCard(): GiftCardService
    {
        return new GiftCardService($this->client);
    }

    /**
     * @return GraphQLService
     */
    public function graphql(): GraphQLService
    {
        return new GraphQLService($this->client);
    }

    /**
     * @return LocationService
     */
    public function location(): LocationService
    {
        return new LocationService($this->client);
    }

    /**
     * @return MarketingEventService
     */
    public function marketingEvent(): MarketingEventService
    {
        return new MarketingEventService($this->client);
    }

    /**
     * @return MetafieldService
     */
    public function metaField(): MetafieldService
    {
        return new MetafieldService($this->client);
    }

    /**
     * @return OrderService
     */
    public function order(): OrderService
    {
        return new OrderService($this->client);
    }

    /**
     * @return PageService
     */
    public function page(): PageService
    {
        return new PageService($this->client);
    }

    /**
     * @return PolicyService
     */
    public function policy(): PolicyService
    {
        return new PolicyService($this->client);
    }

    /**
     * @return PriceRuleService
     */
    public function priceRule(): PriceRuleService
    {
        return new PriceRuleService($this->client);
    }

    /**
     * @return ProductImageService
     */
    public function productImage(): ProductImageService
    {
        return new ProductImageService($this->client);
    }

    /**
     * @return ProductService
     */
    public function product(): ProductService
    {
        return new ProductService($this->client);
    }

    /**
     * @return ProductVariantService
     */
    public function productVariant(): ProductVariantService
    {
        return new ProductVariantService($this->client);
    }

    /**
     * @return ProvinceService
     */
    public function province(): ProvinceService
    {
        return new ProvinceService($this->client);
    }

    /**
     * @return RecurringApplicationChargeService
     */
    public function recurringApplicationCharge(): RecurringApplicationChargeService
    {
        return new RecurringApplicationChargeService($this->client);
    }

    /**
     * @return RedirectService
     */
    public function redirect(): RedirectService
    {
        return new RedirectService($this->client);
    }

    /**
     * @return RefundService
     */
    public function refund(): RefundService
    {
        return new RefundService($this->client);
    }

    /**
     * @return ReportService
     */
    public function report(): ReportService
    {
        return new ReportService($this->client);
    }

    /**
     * @return ScriptTagService
     */
    public function scriptTag(): ScriptTagService
    {
        return new ScriptTagService($this->client);
    }

    /**
     * @return ShippingZoneService
     */
    public function shippingZone(): ShippingZoneService
    {
        return new ShippingZoneService($this->client);
    }

    /**
     * @return ShopService
     */
    public function shop(): ShopService
    {
        return new ShopService($this->client);
    }

    /**
     * @return SmartCollectionService
     */
    public function smartCollection(): SmartCollectionService
    {
        return new SmartCollectionService($this->client);
    }

    /**
     * @return ThemeService
     */
    public function theme(): ThemeService
    {
        return new ThemeService($this->client);
    }

    /**
     * @return TransactionService
     */
    public function transaction(): TransactionService
    {
        return new TransactionService($this->client);
    }

    /**
     * @return UsageChargeService
     */
    public function usageCharge(): UsageChargeService
    {
        return new UsageChargeService($this->client);
    }

    /**
     * @return UserService
     */
    public function user(): UserService
    {
        return new UserService($this->client);
    }

    /**
     * @return WebhookService
     */
    public function webhook(): WebhookService
    {
        return new WebhookService($this->client);
    }
}
