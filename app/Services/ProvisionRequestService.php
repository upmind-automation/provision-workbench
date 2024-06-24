<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\ProviderConfiguration;
use App\Models\ProvisionRequest;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Throwable;
use Upmind\ProvisionBase\ProviderFactory;
use Upmind\ProvisionBase\Provider\DataSet\StorageConfiguration;
use Upmind\ProvisionBase\ProviderJob;
use Upmind\ProvisionBase\Registry\Data\FunctionRegister;
use Upmind\ProvisionBase\Result\ProviderResult;

class ProvisionRequestService
{
    public function create(
        FunctionRegister $function,
        ProviderConfiguration $configuration,
        array $parameterData,
        bool $execute = true
    ): ProvisionRequest {
        if ($function->isConstructor()) {
            throw new InvalidArgumentException('This function is invalid');
        }

        if ($function->getCategory()->getIdentifier() !== $configuration->category_code) {
            throw new InvalidArgumentException('This function is invalid for the given provider configuration');
        }

        $request = new ProvisionRequest();
        $request->category_code = $configuration->category_code;
        $request->provider_code = $configuration->provider_code;
        $request->configuration()->associate($configuration);
        $request->function_name = $function->getName();
        $request->parameter_data = $parameterData;
        $request->save();

        if ($execute) {
            $this->execute($request);
        }

        return $request;
    }

    public function execute(ProvisionRequest $request): ProviderResult
    {
        if ($request->result_status || $request->result_data) {
            throw new InvalidArgumentException('Provision request already has a result');
        }

        $logger = $this->makeLogger($request);
        $result = $this->makeProviderJob($request, $logger)->execute();

        $request->result_status = $result->getStatus();
        $request->result_message = $result->getMessage();
        $request->result_data = $result->getOutput();
        $request->execution_time = $result->getDebug()['execution_time'] ?? null;
        $request->save();

        if ($e = $result->getException()) {
            $logger->error($e->__toString());
        }

        return $result;
    }

    public function getLogs(ProvisionRequest $request): ?string
    {
        try {
            return trim((string)File::get($this->getLogPath($request))) ?: null;
        } catch (FileNotFoundException $e) {
            return null;
        }
    }

    public function delete(ProvisionRequest $request): void
    {
        if (File::exists($logPath = $this->getLogPath($request))) {
            File::delete($logPath);
        }

        $request->delete();
    }

    protected function getLogPath(ProvisionRequest $request): string
    {
        return storage_path(sprintf('logs/provision_requests/%s.log', $request->id));
    }

    protected function makeProviderJob(ProvisionRequest $request, ?LoggerInterface $logger = null): ProviderJob
    {
        /** @var \Upmind\ProvisionBase\ProviderFactory $factory */
        $factory = App::make(ProviderFactory::class);
        $factory->setLogger($logger ?? $this->makeLogger($request));

        $provider = $factory->create(
            $request->category_code,
            $request->provider_code,
            $request->configuration->data
        );

        return $provider->makeJob($request->function_name, $request->parameter_data);
    }

    protected function makeLogger(ProvisionRequest $request): LoggerInterface
    {
        $loggerConfig = [
            'driver' => 'single',
            'path' => $this->getLogPath($request),
            'level' => 'debug',
        ];
        $loggerConfigKey = sprintf('provision_request_%s', $request->id);

        Config::set(sprintf('logging.channels.%s', $loggerConfigKey), $loggerConfig);

        return Log::channel($loggerConfigKey);
    }
}
