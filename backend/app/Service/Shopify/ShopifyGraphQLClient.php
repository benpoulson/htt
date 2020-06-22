<?php

namespace App\Service\Shopify;

use App\Exceptions\ShopifyException;
use App\ShopifyStore;
use GraphQL\Client;
use GraphQL\Mutation;
use GraphQL\Query;
use GraphQL\Results;
use Illuminate\Support\Str;

/**
 * Class ShopifyGraphQLClient
 * @package App\Service\Shopify
 */
final class ShopifyGraphQLClient extends ShopifyClient
{
    private Client $gqlClient;

    /**
     * ShopifyClient constructor.
     * @param ShopifyStore $store
     */
    public function __construct(ShopifyStore $store)
    {
        parent::__construct($store);
        $this->gqlClient = new Client(
            sprintf('%s/graphql.json', $this->getApiDomain()),
            ['Authorization' => $this->getAuthorizationHeaderValue()]
        );
    }

    /**
     * Start editing an order.
     * @param string $orderId
     * @return Results
     * @throws ShopifyException
     */
    public function orderEditBegin(string $orderId)
    {
        return $this->mutatorOperation(
            __FUNCTION__,
            (new Query('calculatedOrder'))->setSelectionSet(['id']),
            ['id' => $orderId]
        );
    }

    /**
     * Applies and saves staged changes to an order.
     * @param string $calculatedOrderId
     * @return Results
     * @throws ShopifyException
     */
    public function orderEditCommit(string $calculatedOrderId)
    {
        return $this->mutatorOperation(
            __FUNCTION__,
            (new Query('order'))->setSelectionSet(['id']),
            ['id' => $calculatedOrderId]
        );
    }

    /**
     * Add a line item from an existing product variant.
     * @param string $calculatedOrderId
     * @param string $variantId
     * @param int $quantity
     * @return Results
     * @throws ShopifyException
     */
    public function orderEditAddVariant(string $calculatedOrderId, string $variantId, int $quantity)
    {
        return $this->mutatorOperation(
            __FUNCTION__,
            [
                (new Query('calculatedLineItem'))->setSelectionSet(['id']),
                (new Query('calculatedOrder'))->setSelectionSet(['id']),
            ],
            [
                'id' => $calculatedOrderId,
                'variantId' => $variantId,
                'quantity' => $quantity
            ]
        );
    }

    /**
     * Set the quantity of an item on the order.
     * @param string $calculatedOrderId
     * @param string $lineItemId
     * @param int $quantity
     * @return Results
     * @throws ShopifyException
     */
    public function orderEditSetQuantity(string $calculatedOrderId, string $lineItemId, int $quantity)
    {
        return $this->mutatorOperation(
            __FUNCTION__,
            [
                (new Query('calculatedLineItem'))->setSelectionSet(['id']),
                (new Query('calculatedOrder'))->setSelectionSet(['id']),
            ],
            [
                'id' => $calculatedOrderId,
                'lineItemId' => $lineItemId,
                'quantity' => $quantity
            ]
        );
    }

    /**
     * Add a custom item to the order.
     * @param string $calculatedOrderId
     * @param string $title
     * @param float $price
     * @param string $priceCurrency
     * @param int $quantity
     * @return Results
     * @throws ShopifyException
     */
    public function orderEditAddCustomItem(string $calculatedOrderId, string $title, float $price, string $priceCurrency, int $quantity, bool $requiresShipping)
    {
        return $this->mutatorOperation(
            __FUNCTION__,
            [
                (new Query('calculatedLineItem'))->setSelectionSet(['id']),
                (new Query('calculatedOrder'))->setSelectionSet(['id']),
            ],
            [
                'id' => $calculatedOrderId,
                'title' => $title,
                'price' => [
                    'amount' => $price,
                    'currencyCode' => $priceCurrency,
                ],
                'quantity' => $quantity,
                'requiresShipping' => $requiresShipping
            ]
        );
    }

    public function orderCapture()
    {
        //todo
    }

    public function orderClose()
    {
        //todo
    }

    public function orderMarkAsPaid()
    {
        //todo
    }

    public function orderOpen()
    {
        //todo
    }

    public function orderUpdate()
    {
        //todo
    }

    /**
     * A wrapper function for easily issuing and processing mutator operations
     * @param string $operation
     * @param mixed $selectionSet Can either be a Query, or an array of Query objects
     * @param array $arguments
     * @return Results
     * @throws ShopifyException
     */
    protected function mutatorOperation(string $operation, $selectionSet, array $arguments = []): Results
    {
        // Force selection set to be an array
        if (!is_array($selectionSet)) {
            $selectionSet = [$selectionSet];
        }

        // Always splice in the userErrors query
        $selectionSet[] = (new Query('userErrors'))->setSelectionSet(['field', 'message']);

        // Run the query
        $result = $this->gqlClient->runQuery(
            (new Mutation($operation))
                ->setOperationName($operation)
                ->setArguments($arguments)
                ->setSelectionSet($selectionSet)
        );

        // Check for errors and raise an exception if need be
        $errors = $result->getData()->{$operation}->userErrors;
        if (count($errors)) {
            throw new ShopifyException(
                sprintf(
                    'GraphQL Error: %s "%s" triggered error - %s',
                    Str::plural('Field', count($errors[0]->field)),
                    implode(', ', $errors[0]->field),
                    $errors[0]->message
                )
            );
        }

        return $result;
    }
}
