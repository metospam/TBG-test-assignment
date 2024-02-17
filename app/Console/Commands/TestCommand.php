<?php

namespace App\Console\Commands;

use App\Services\Impl\TelegramServiceImpl;
use Illuminate\Console\Command;
use WeStacks\TeleBot\Exceptions\TeleBotException;
use WeStacks\TeleBot\TeleBot;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     * @throws TeleBotException
     */
    public function handle()
    {
        $service = new TelegramServiceImpl(new TeleBot(config('telegram.token')));
    }
}
