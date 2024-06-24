<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
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
	class ProviderConfiguration extends \Eloquent {}
}

namespace App\Models{
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
	class ProvisionRequest extends \Eloquent {}
}

