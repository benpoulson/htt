<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

/**
 * Class MessageTransformer
 * @package App\Transformers
 */
class MessageTransformer extends TransformerAbstract
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
     * @param string $message
     * @return array
     */
    public function transform(string $message)
    {
        return [
            'message' => $message
        ];
    }
}
