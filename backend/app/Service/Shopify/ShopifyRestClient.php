<?php

namespace App\Service\Shopify;

use App\ShopifyStore;
use Closure;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * Class ShopifyRestClient
 * @package App\Service\Shopify
 */
class ShopifyRestClient extends ShopifyClient
{
    private Client $client;

    /**
     * ShopifyClient constructor.
     * @param ShopifyStore $store
     */
    public function __construct(ShopifyStore $store)
    {
        parent::__construct($store);

        // Custom stack to deal with rate limiting errors
        $stack = HandlerStack::create();
        $stack->push(Middleware::retry($this->retryDecider(), $this->retryDelay()));

        $this->client = new Client([
            'base_uri' => $this->getApiDomain(),
            'headers' => [
                'Authorization' => $this->getAuthorizationHeaderValue()
            ],
            'handler' => $stack
        ]);
    }

    /**
     * Retrieve a list of Orders (OPEN Orders by default, use status=any for ALL orders)
     * @link https://help.shopify.com/api/reference/order#index
     * @param array $params
     * @return array
     * @throws GuzzleException
     */
    public function allOrders(array $params = [])
    {
        return $this->request('orders.json', 'GET', $params);
    }

    /**
     * Receive a count of all Orders
     * @link   https://help.shopify.com/api/reference/order#show
     * @param array $params
     * @return integer
     * @throws GuzzleException
     */
    public function countOrders(array $params = [])
    {
        $response = $this->request('orders/count.json', 'GET', $params);
        return $response['count'];
    }

    /**
     * Receive a single Order
     *
     * @link https://help.shopify.com/api/reference/order#count
     * @param integer $orderId
     * @param array $params
     * @return object
     * @throws GuzzleException
     */
    public function getOrder(int $orderId, array $params = [])
    {
        return $this->request(sprintf('orders/%d.json', $orderId), 'GET', $params);
    }

    /**
     * Create a new order
     * @link https://help.shopify.com/api/reference/order#create
     * @param array $order
     * @return void
     * @throws GuzzleException
     */
    public function createOrder(array $order)
    {
        return $this->request('orders.json', 'POST', ['order' => $order]);
    }

    /**
     * Close an order
     * @link https://help.shopify.com/api/reference/order#close
     * @param int $orderId
     * @return void
     * @throws GuzzleException
     */
    public function closeOrder(int $orderId)
    {
        return $this->request(sprintf('orders/%d/close.json', $orderId), 'POST');
    }

    /**
     * Re-open a closed Order
     * @link https://help.shopify.com/api/reference/order#open
     * @param int $orderId
     * @return void
     * @throws GuzzleException
     */
    public function openOrder(int $orderId)
    {
        return $this->request(sprintf('orders/%d/open.json', $orderId), 'POST');
    }

    /**
     * Cancel an Order
     * @link https://help.shopify.com/api/reference/order#cancel
     * @param int $orderId
     * @return void
     * @throws GuzzleException
     */
    public function cancelOrder(int $orderId)
    {
        return $this->request(sprintf('orders/%d/cancel.json', $orderId), 'POST');
    }

    /**
     * Modify an existing order
     * @link https://help.shopify.com/api/reference/order#update
     * @param int $orderId
     * @param array $data
     * @return void
     * @throws GuzzleException
     */
    public function updateOrder(int $orderId, array $data)
    {
        return $this->request(sprintf('orders/%d.json', $orderId), 'POST', [
            'order' => $data
        ]);
    }

    /**
     * Delete an order
     * @link https://help.shopify.com/api/reference/order#destroy
     * @param int $orderId
     * @return void
     * @throws GuzzleException
     */
    public function deleteOrder(int $orderId)
    {
        return $this->request(sprintf('orders/%d.json', $orderId), 'DELETE');
    }

    /**
     * @param string $endpoint
     * @param string $method
     * @param array $params
     * @return mixed
     * @throws GuzzleException
     */
    private function request(string $endpoint, string $method = 'GET', array $params = [])
    {
        $apiResponse = $this->client->send(new Request($method, $endpoint), [
            $method === 'GET' ? 'query' : 'json' => $params
        ]);

        $response = [];

        // Splice in pagination headers
        if ($apiResponse->hasHeader('Link')) {
            $linkHeader = $apiResponse->getHeaderLine('Link');

            // Regex the awful header values apart
            preg_match_all('/<(.*?)>; rel="(.*?)"/', $linkHeader, $matches, PREG_SET_ORDER);

            // Pull the pagination parameters out of the awful header syntax
            $response['meta']['pagination'] = [];
            foreach ($matches as $match) {
                $parsedUrl = parse_url($match[1]);
                if ($parsedUrl['query']) {
                    $parsedQuery = null;
                    parse_str($parsedUrl['query'], $parsedQuery);
                    if ($parsedQuery['page_info']) {
                        $response['meta']['pagination'][$match[2]] = $parsedQuery['page_info'];
                    }
                }
            }
        }

        // Splice in rate limit headers
        if ($apiResponse->hasHeader('HTTP_X_SHOPIFY_SHOP_API_CALL_LIMIT')) {
            list($limit, $value) = explode('/', $apiResponse->getHeaderLine('HTTP_X_SHOPIFY_SHOP_API_CALL_LIMIT'), 2);
            $response['meta']['ratelimit'] = [
                'limit' => (int)$limit,
                'current' => (int)$value,
            ];
        }

        $response['data'] = json_decode($apiResponse->getBody()->getContents(), true);

        return $response;
    }

    /**
     * Simple exponential backoff calculation
     * @return Closure
     */
    private function retryDelay(): Closure
    {
        return function (int $numberOfRetries) {
            return $numberOfRetries * 1000;
        };
    }

    /**
     * Decides whether a Shopify API request should be retried or not.
     * @return Closure
     */
    private function retryDecider(): Closure
    {
        /**
         * @param $retries
         * @param Request $request
         * @param Response|null $response
         * @param RequestException|null $exception
         * @return bool
         */
        return function ($retries, Request $request, Response $response = null, RequestException $exception = null) {

            // Limit the number of retries
            if ($retries >= config('shopify.max_retry_count')) {
                return false;
            }

            // Don't allow request retrying on DELETE endpoints, it's just safer...
            if ($request->getMethod() === 'DELETE') {
                return false;
            }

            // Retry connection exceptions, even though they shouldn't ever happen...
            if ($exception instanceof ConnectException) {
                return true;
            }

            if ($response) {
                // Retry on 429 requests (See https://shopify.dev/concepts/about-apis/rate-limits#avoiding-rate-limit-errors)
                if ($response->getStatusCode() === SymfonyResponse::HTTP_TOO_MANY_REQUESTS) {
                    return true;
                }
            }

            return false;
        };
    }
}
