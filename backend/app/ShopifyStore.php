<?php

namespace App;

use App\Service\Shopify\ShopifyService;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\ShopifyStore
 *
 * @property int $id
 * @property string $name
 * @property string $domain
 * @property string $api_key
 * @property string $password
 * @property string $shared_secret
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ShopifyStore newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ShopifyStore newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ShopifyStore query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ShopifyStore whereApiKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ShopifyStore whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ShopifyStore whereDomain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ShopifyStore whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ShopifyStore whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ShopifyStore wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ShopifyStore whereSharedSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ShopifyStore whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ShopifyStore extends EncryptableModel
{

    protected $fillable = [
        'name',
        'domain',
        'api_key',
        'password',
        'shared_secret'
    ];
    protected $hidden = [
        'api_key',
        'password',
        'shared_secret'
    ];

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Enables encryption on specific fields
     * @return array|string[]
     */
    public function getEncryptedFields(): array
    {
        return [
            'api_key',
            'password',
            'shared_secret'
        ];
    }

    /**
     * @return ShopifyService
     */
    public function getService(): ShopifyService
    {
        return new ShopifyService($this);
    }
}
