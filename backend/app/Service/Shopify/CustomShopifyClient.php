<?php

namespace App\Service\Shopify;

use Closure;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Shopify\PrivateApi;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * Class ShopifyApi
 * A wrapper of the PrivateApi that allows for rate limiting and automatic retrying of requests
 * @package App\Service
 */
final class CustomShopifyClient extends PrivateApi
{
    const MAX_RETRY_COUNT = 5;

    public function init(): void
    {
        // Custom stack to deal with rate limiting errors
        $stack = HandlerStack::create();
        $stack->push(Middleware::retry($this->retryDecider(), $this->retryDelay()));

        $args = array(
            'base_uri' => sprintf("https://%s/admin/api/%s", $this->myshopify_domain, $this->getApiVersion()),
            'headers' => [
                'Authorization' => $this->createBasicAuthHeader($this->api_key, $this->password)
            ],
            'handler' => $stack
        );
        $this->http_handler = new Client($args);
    }

    /**
     * Simple exponential backoff calculation
     * @return Closure
     */
    protected function retryDelay(): Closure
    {
        return function (int $numberOfRetries) {
            return $numberOfRetries * 1000;
        };
    }

    /**
     * Decides whether a Shopify API request should be retried or not.
     * @return Closure
     */
    protected function retryDecider(): Closure
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
            if ($retries >= self::MAX_RETRY_COUNT) {
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
                if ($response->getStatusCode() == SymfonyResponse::HTTP_TOO_MANY_REQUESTS) {
                    return true;
                }
            }

            return false;
        };
    }
}
