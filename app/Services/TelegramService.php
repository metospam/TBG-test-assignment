<?php

namespace App\Services;

interface TelegramService
{
    public function sendFile(string $username, string $filePath): void;
}
