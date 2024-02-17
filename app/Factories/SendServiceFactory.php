<?php

namespace App\Factories;

use App\Services\MailService;
use App\Services\TelegramService;

interface SendServiceFactory
{
    public function create(string $type): TelegramService|MailService;
}
