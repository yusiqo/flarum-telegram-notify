<?php

namespace TelegramNotify\Listeners;

use Flarum\Post\Event\Posted;
use Flarum\Settings\SettingsRepositoryInterface;

class PostCreatedListener
{
    protected $settings;

    public function __construct(SettingsRepositoryInterface $settings)
    {
        $this->settings = $settings;
    }

    public function handle(Posted $event)
    {
        $botToken = $this->settings->get('telegram-notify.bot_token');
        $chatId = $this->settings->get('telegram-notify.chat_id');

        if (!$botToken || !$chatId) {
            return;
        }

        $post = $event->post;
        $message = "Yeni bir gönderi oluşturuldu:\n\n";
        $message .= "Konu: {$post->discussion->title}\n";
        $message .= "Yazar: {$post->user->username}\n";
        $message .= "Mesaj: {$post->content}\n";
        $message .= "Bağlantı: " . url("/d/{$post->discussion_id}/{$post->number}");

        $this->sendToTelegram($botToken, $chatId, $message);
    }

    private function sendToTelegram($botToken, $chatId, $message)
    {
        $url = "https://api.telegram.org/bot{$botToken}/sendMessage";

        $data = [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'Markdown',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_exec($ch);
        curl_close($ch);
    }
}
