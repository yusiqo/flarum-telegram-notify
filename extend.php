<?php

use Flarum\Extend;
use Flarum\Settings\SettingsRepositoryInterface;

return [
    (new Extend\Settings())
        ->serializeToForum('telegramNotifyBotToken', 'telegram-notify.bot_token')
        ->serializeToForum('telegramNotifyChatId', 'telegram-notify.chat_id')
        ->serializeToForum('telegramNotifyMessageTemplate', 'telegram-notify.message_template')
        ->serializeToForum('telegramNotifyButtonText', 'telegram-notify.button_text'),

    (new Extend\Frontend('admin'))
        ->content(function ($document) {
            $settings = resolve('flarum.settings');
            $document->payload['telegramNotifySettings'] = [
                'bot_token' => $settings->get('telegram-notify.bot_token'),
                'chat_id' => $settings->get('telegram-notify.chat_id'),
                'message_template' => $settings->get('telegram-notify.message_template', "Yeni bir gönderi oluşturuldu:\n\nBaşlık: {title}\nYazar: {author}\nMesaj: {content}\nBağlantı: {link}"),
                'button_text' => $settings->get('telegram-notify.button_text', 'Gönderiyi Görüntüle'),
            ];
        }),


    (new Extend\Event())
        ->listen(\Flarum\Post\Event\Posted::class, \TelegramNotify\Listeners\PostCreatedListener::class),
];
