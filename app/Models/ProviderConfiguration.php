<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Upmind\ProvisionBase\Registry\Data\CategoryRegister;
use Upmind\ProvisionBase\Registry\Data\ProviderRegister;
use Upmind\ProvisionBase\Registry\Registry;

/**
 * App\Models\ProviderConfiguration
 *
 * @property int $id
 * @property string $category_code
 * @property string $provider_code
 * @property string $name
 * @property array $data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder|ProviderConfiguration newModelQuery()
 * @method static Builder|ProviderConfiguration newQuery()
 * @method static Builder|ProviderConfiguration query()
 * @method static Builder|ProviderConfiguration whereCategory($category)
 * @method static Builder|ProviderConfiguration whereCategoryCode($value)
 * @method static Builder|ProviderConfiguration whereCreatedAt($value)
 * @method static Builder|ProviderConfiguration whereData($value)
 * @method static Builder|ProviderConfiguration whereId($value)
 * @method static Builder|ProviderConfiguration whereName($value)
 * @method static Builder|ProviderConfiguration whereProvider($provider)
 * @method static Builder|ProviderConfiguration whereProviderCode($value)
 * @method static Builder|ProviderConfiguration whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProviderConfiguration extends Model
{
    protected $casts = [
        'data' => 'json',
    ];

    /**
     * @param Builder $query
     * @param string|CategoryRegister $category
     *
     * @return Builder
     */
    public function scopeWhereCategory($query, $category)
    {
        if ($category instanceof CategoryRegister) {
            $category = $category->getIdentifier();
        }

        return $query->where('category_code', $category);
    }

    /**
     * @param Builder $query
     * @param string|ProviderRegister $provider
     *
     * @return Builder
     */
    public function scopeWhereProvider($query, $provider)
    {
        if ($provider instanceof ProviderRegister) {
            $provider = $provider->getIdentifier();
        }

        return $query->where('provider_code', $provider);
    }

    public function getCategory(): ?CategoryRegister
    {
        return App::make(Registry::class)->getCategory($this->category_code);
    }

    public function getProvider(): ?ProviderRegister
    {
        if (!$category = $this->getCategory()) {
            return null;
        }

        return $category->getProvider($this->provider_code);
    }
}
