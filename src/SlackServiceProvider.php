<?php

namespace Fred\SlackService;

use Illuminate\Support\ServiceProvider;

class SlackServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerClients();
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/slack.php' => config_path('slack.php'),
        ], 'config');
    }

    protected function registerClients(): void
    {
        $clients = (array) config('slack.clients');

        array_walk($clients, function ($config, $name) {
            $this->app->bind('slack-'.$name, function () use ($config) {
                return new Client($config['endpoint'], $config['channel'], $config['username']);
            });
        });
    }
}