<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Upmind\ProvisionBase\Registry\Data\CategoryRegister;
use Upmind\ProvisionBase\Registry\Data\FunctionRegister;
use Upmind\ProvisionBase\Registry\Data\ProviderRegister;
use Upmind\ProvisionBase\Registry\Registry;
use Upmind\ProvisionBase\Result\Result;

/**
 * App\Models\ProvisionRequest
 *
 * @property int $id
 * @property string $category_code
 * @property string $provider_code
 * @property int $configuration_id
 * @property string $function_name
 * @property array $parameter_data
 * @property string|null $result_status
 * @property string|null $result_message
 * @property array|null $result_data
 * @property float|null $execution_time
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ProviderConfiguration $configuration
 * @property-read array $flat_parameter_data
 * @method static Builder|ProvisionRequest newModelQuery()
 * @method static Builder|ProvisionRequest newQuery()
 * @method static Builder|ProvisionRequest query()
 * @method static Builder|ProvisionRequest whereCategory($category)
 * @method static Builder|ProvisionRequest whereCategoryCode($value)
 * @method static Builder|ProvisionRequest whereConfigurationId($value)
 * @method static Builder|ProvisionRequest whereCreatedAt($value)
 * @method static Builder|ProvisionRequest whereExecutionTime($value)
 * @method static Builder|ProvisionRequest whereFunctionName($value)
 * @method static Builder|ProvisionRequest whereId($value)
 * @method static Builder|ProvisionRequest whereParameterData($value)
 * @method static Builder|ProvisionRequest whereProvider($provider)
 * @method static Builder|ProvisionRequest whereProviderCode($value)
 * @method static Builder|ProvisionRequest whereResultData($value)
 * @method static Builder|ProvisionRequest whereResultMessage($value)
 * @method static Builder|ProvisionRequest whereResultStatus($value)
 * @method static Builder|ProvisionRequest whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProvisionRequest extends Model
{
    protected $casts = [
        'parameter_data' => 'json',
        'result_data' => 'json',
    ];

    public function configuration(): BelongsTo
    {
        return $this->belongsTo(ProviderConfiguration::class);
    }

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

    public function getFlatParameterDataAttribute(): array
    {
        return Arr::dot($this->getAttribute('parameter_data'));
    }

    public function getCategory(): ?CategoryRegister
    {
        return App::make(Registry::class)->getCategory($this->category_code);
    }

    public function getCategoryName(): ?string
    {
        if (!$category = $this->getCategory()) {
            return null;
        }

        return $category->getAbout()->name;
    }

    public function getCategoryIcon(): ?string
    {
        if (!$category = $this->getCategory()) {
            return null;
        }

        return $category->getAbout()->icon;
    }

    public function getProvider(): ?ProviderRegister
    {
        if (!$category = $this->getCategory()) {
            return null;
        }

        return $category->getProvider($this->provider_code);
    }

    public function getProviderName(): ?string
    {
        if (!$provider = $this->getProvider()) {
            return null;
        }

        return $provider->getAbout()->name;
    }

    public function getProviderIcon(): ?string
    {
        if (!$provider = $this->getProvider()) {
            return null;
        }

        return $provider->getAbout()->icon;
    }

    public function getFunction(): ?FunctionRegister
    {
        if (!$category = $this->getCategory()) {
            return null;
        }

        return $category->getFunction($this->function_name);
    }

    public function getFunctionName(): string
    {
        return $this->function_name;
    }

    public function getConfigurationName(): ?string
    {
        return $this->configuration->name ?? null;
    }

    public function getResult(): ?Result
    {
        if (is_null($this->result_data)) {
            return null;
        }

        return Result::createFromArray($this->result_data);
    }

    public function hasResult(): bool
    {
        return isset($this->result_data);
    }

    public function isSuccess(): bool
    {
        return $this->result_status === Result::STATUS_OK;
    }

    public function isError(): bool
    {
        return $this->result_status === Result::STATUS_ERROR;
    }
}
