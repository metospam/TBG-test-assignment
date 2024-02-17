<?php

namespace App\Services\Impl;

use App\Services\TelegramService;
use WeStacks\TeleBot\TeleBot;

class TelegramServiceImpl implements TelegramService
{

    /**
     * Constructs a new instance of the Telegram service.
     *
     * @param TeleBot $bot The TeleBot instance to use for communication.
     */
    public function __construct(
        protected TeleBot $bot,
    )
    {
    }

    /**
     * Sends a file to the user identified by the given username.
     *
     * @param string $username The username of the recipient.
     * @param string $filePath The path to the file to be sent.
     * @return void
     */
    public function sendFile(string $username, string $filePath): void
    {
        $this->bot->sendDocument([
            'chat_id' => $this->getChatId($username),
            'document' => $filePath,
        ]);
    }

    /**
     * Retrieves the chat ID associated with the given username.
     *
     * @param string $username The username for which to retrieve the chat ID.
     * @return string The chat ID of the user, or an empty string if not found.
     */
    public function getChatId(string $username): string
    {
        $chats = $this->getChatsData();
        $results = $chats['result'];

        foreach ($results as $result){
            if(isset($result['message'])){
                $resultUsername = $result['message']['chat']['username'];
                if($username === $resultUsername){
                    return $result['message']['chat']['id'];
                }
            }
        }

        return '';
    }

    /**
     * Retrieves chat data from the Telegram API.
     *
     * @return array An array containing chat data retrieved from the Telegram API.
     */
    public function getChatsData(): array
    {
        $botToken = config('telegram.token');
        $telegramApiUrl = "https://api.telegram.org/bot$botToken";

        $response = file_get_contents("$telegramApiUrl/getUpdates");
        return json_decode($response, true);
    }

}
