<?php

namespace App\Services;

interface SendService
{
    public function sendFile(string $toSend, string $filePath): void;
}
