<?php

namespace App\Providers;

use App\Factories\Impl\SendServiceFactoryImpl;
use App\Factories\SendServiceFactory;
use App\Repositories\Impl\UserRepositoryImpl;
use App\Repositories\UserRepository;
use App\Services\Impl\MailServiceImpl;
use App\Services\Impl\TelegramServiceImpl;
use App\Services\Impl\UploadServiceImpl;
use App\Services\MailService;
use App\Services\TelegramService;
use App\Services\UploadService;
use Illuminate\Support\ServiceProvider;
use WeStacks\TeleBot\TeleBot;

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
        $this->app->bind(TelegramService::class, TelegramServiceImpl::class);
        $this->app->bind(SendServiceFactory::class, SendServiceFactoryImpl::class);
        $this->app->bind(MailService::class, MailServiceImpl::class);
        $this->app->bind(UploadService::class, UploadServiceImpl::class);
        $this->app->bind(UserRepository::class, UserRepositoryImpl::class);
        $this->app->bind(TeleBot::class, function () {
            try {
                return new TeleBot(config('telegram.token'));
            } catch (\Exception $e) {
                return null;
            }
        });
    }
}
