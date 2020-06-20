<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

/**
 * Class JWTTransformer
 * @package App\Transformers
 */
class JWTTransformer extends TransformerAbstract
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
     * @param array $jwt
     * @return array
     */
    public function transform(array $jwt)
    {
        return [
            'access_token' => $jwt['token'],
            'token_type' => 'bearer',
            'expires_in' => $jwt['ttl']
        ];
    }
}
