<?php

namespace App\Factories\Impl;

use App\Factories\SendServiceFactory;
use App\Services\MailService;
use App\Services\SendService;
use App\Services\TelegramService;
use InvalidArgumentException;

class SendServiceFactoryImpl implements SendServiceFactory
{

    /**
     * Create a notification service based on the given type.
     *
     * @param string $type The type of notification service to create (e.g., "telegram" or "email").
     *
     * @return SendService The created notification service.
     *
     * @throws InvalidArgumentException If the provided service type is not supported.
     */
    public function create(string $type): SendService
    {
        return match ($type) {
            'telegram' => app(TelegramService::class),
            'email' => app(MailService::class),
            default => throw new InvalidArgumentException("Unsupported service type: $type"),
        };
    }

}
