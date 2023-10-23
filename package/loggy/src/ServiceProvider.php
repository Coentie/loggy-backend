<?php

namespace DeepDigital\Loggy;

use DeepDigital\Loggy\Client\Client;
use DeepDigital\Loggy\Client\ClientInterface;
use  Illuminate\Support\ServiceProvider as BaseProvider;
use DeepDigital\Loggy\Commands\PublishSettingsCommand;
use GuzzleHttp\Client as GuzzleClient;

class ServiceProvider extends BaseProvider
{
    /**
     * Abstract identifier of the package.
     *
     * @var string
     */
    protected static $abstract = 'loggy';

    /**
     * Register the package to Laravel
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ClientInterface::class, function () {
            $client = new GuzzleClient([
                'base_uri' => Server::URL . '/api'
            ]);

            return new Client($client);
        });
    }

    /**
     * Register when the application is booted up
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerCommands();
    }

    /**
     * Register the artisan commands.
     */
    protected function registerCommands(): void
    {
        $this->commands([
            PublishSettingsCommand::class,
        ]);
    }
}
