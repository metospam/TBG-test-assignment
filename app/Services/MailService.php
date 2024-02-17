<?php

namespace App\Services;

interface MailService
{
    public function sendFile(string $email, string $filePath): void;
}
