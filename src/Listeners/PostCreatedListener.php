<?php

namespace Yusiqo\TgNotify\Listeners;

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
        $messageTemplate = $this->settings->get('telegram-notify.message_template', "Yeni bir gönderi oluşturuldu:\n\nBaşlık: {title}\nYazar: {author}\nMesaj: {content}\nBağlantı: {link}");
        $buttonText = $this->settings->get('telegram-notify.button_text', "Gönderiyi Görüntüle");

        if (!$botToken || !$chatId) {
            return;
        }

        $post = $event->post;
        $message = str_replace(
            ['{title}', '{author}', '{content}', '{link}'],
            [
                htmlspecialchars($post->discussion->title),
                htmlspecialchars($post->user->username),
                htmlspecialchars($post->content),
                url("/d/{$post->discussion_id}/{$post->number}")
            ],
            $messageTemplate
        );

        // Inline Buton Yapısı
        $button = [
            'inline_keyboard' => [
                [
                    ['text' => $buttonText, 'url' => url("/d/{$post->discussion_id}/{$post->number}")]
                ]
            ]
        ];

        $this->sendToTelegram($botToken, $chatId, $message, $button);
    }

    private function sendToTelegram($botToken, $chatId, $message, $button)
    {
        $url = "https://api.telegram.org/bot{$botToken}/sendMessage";

        $data = [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'HTML',
            'reply_markup' => json_encode($button),
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
