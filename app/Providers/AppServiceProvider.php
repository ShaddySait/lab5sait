<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // map Azure environment variables to Laravel's expected database config
        // so migrations and the database layer can read the right values.
        if (env('AZURE_MYSQL_USERNAME')) {
            // set config values directly; config() will merge with existing values
            config([
                'database.connections.mysql.username' => env('AZURE_MYSQL_USERNAME'),
                'database.connections.mysql.password' => env('AZURE_MYSQL_PASSWORD'),
                'database.connections.mysql.host' => env('AZURE_MYSQL_HOST', config('database.connections.mysql.host')),
                'database.connections.mysql.database' => env('AZURE_MYSQL_DATABASE', config('database.connections.mysql.database')),
            ]);

            // optionally override the $_ENV variables so env() calls elsewhere also work
            $_ENV['DB_USERNAME'] = env('AZURE_MYSQL_USERNAME');
            $_ENV['DB_PASSWORD'] = env('AZURE_MYSQL_PASSWORD');
            $_ENV['DB_HOST'] = env('AZURE_MYSQL_HOST', $_ENV['DB_HOST'] ?? null);
            $_ENV['DB_DATABASE'] = env('AZURE_MYSQL_DATABASE', $_ENV['DB_DATABASE'] ?? null);
        }
    }
}
