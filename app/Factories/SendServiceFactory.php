<?php

namespace App\Factories;

use App\Services\SendService;

interface SendServiceFactory
{
    public function create(string $type): SendService;
}
