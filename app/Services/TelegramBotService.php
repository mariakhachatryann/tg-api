<?php

namespace App\Services;

use GuzzleHttp\Client;

class TelegramBotService
{
    private $token;
    private $url;

    public function __construct()
    {
        $this->token = env('TELEGRAM_BOT_TOKEN');
        $this->url = "https://api.telegram.org/bot{$this->token}/";
    }

    public function getUpdates()
    {
        $client = new Client();
        $response = $client->get("{$this->url}getUpdates?offset=-2");
        return json_decode($response->getBody()->getContents(), true);
    }

    public function sendMessage($chatId, $message)
    {
        $client = new Client();
        $response = $client->post("{$this->url}sendMessage", [
            'json' => [
                'chat_id' => $chatId,
                'text' => $message,
            ]
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
