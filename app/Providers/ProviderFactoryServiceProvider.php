<?php

namespace App\Providers;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Psr\Log\LoggerInterface;
use Upmind\ProvisionBase\Provider\DataSet\SystemInfo;
use Upmind\ProvisionBase\ProviderFactory;
use Upmind\ProvisionBase\Registry\Registry;

class ProviderFactoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(SystemInfo::class, function ($app) {
            return new SystemInfo([
                'outgoing_ips' => $this->getOutgoingIps(),
            ]);
        });

        $this->app->singleton(ProviderFactory::class, function ($app) {
            return new ProviderFactory(
                $app->make(Registry::class),
                $app->make(Filesystem::class),
                $app->make(LoggerInterface::class),
                $app->make(SystemInfo::class),
            );
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * @return string[]
     */
    protected function getOutgoingIps(): array
    {
        // Get IPs from config
        if ($ips = array_filter(array_map('trim', explode(',', config('app.outgoing_ips') ?: '')))) {
            return $ips;
        }

        // Try to determine IP automatically
        return Arr::wrap(
            isset($_SERVER['SERVER_ADDR'])
                ? $_SERVER['SERVER_ADDR']
                : gethostbyname(gethostname() ?: php_uname('n'))
        );
    }
}
