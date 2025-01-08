<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;


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
    public function boot()
{
    try {
        DB::connection()->getPdo();
        if (!Schema::hasTable('migrations')) {
            Artisan::call('migrate', ['--force' => true]);
        }
    } catch (\Exception $e) {
        \Log::error('Could not connect to the database. Please check your configuration. Error: ' . $e->getMessage());
    }
}
}
