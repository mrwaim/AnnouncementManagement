<?php

namespace Klsandbox\AnnouncementManagement;

use Illuminate\Support\ServiceProvider;
use Klsandbox\AnnouncementManagement\Console\Commands\AdminSendAnnouncement;

class AnnouncementManagementServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('command.klsandbox.adminsendannouncement', function () {
            return new AdminSendAnnouncement();
        });

        $this->commands('command.klsandbox.adminsendannouncement');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    public function boot()
    {
        if (!$this->app->routesAreCached()) {
            require __DIR__ . '/../../../routes/routes.php';
        }

        $this->loadViewsFrom(__DIR__ . '/../../../views/', 'announcement-management');

        $this->publishes([
            __DIR__ . '/../../../views/' => base_path('resources/views/vendor/announcement-management'),
        ], 'views');

        $this->publishes([
            __DIR__ . '/../../../database/migrations/' => database_path('/migrations'),
        ], 'migrations');
    }
}
