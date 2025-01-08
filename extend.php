<?php

namespace Yusiqo\TgNotify;
use Flarum\Extend;
use Flarum\Settings\SettingsRepositoryInterface;
use Flarum\Extension\ExtensionManager;

class SettingsModal
{
    public function __invoke(SettingsRepositoryInterface $settings)
    {
        return [
            'bot_token' => $settings->get('telegram-notify.bot_token', ''),
            'chat_id' => $settings->get('telegram-notify.chat_id', ''),
            'message_template' => $settings->get('telegram-notify.message_template', "Yeni bir gönderi oluşturuldu:\n\nBaşlık: {title}\nYazar: {author}\nMesaj: {content}\nBağlantı: {link}"),
            'button_text' => $settings->get('telegram-notify.button_text', 'Gönderiyi Görüntüle'),
        ];
    }
}

return [
    (new Extend\Settings())
        ->serializeToForum('telegramNotifyBotToken', 'telegram-notify.bot_token')
        ->serializeToForum('telegramNotifyChatId', 'tealegram-notify.chat_id')
        ->serializeToForum('telegramNotifyMessageTemplate', 'telegram-notify.message_template')
        ->serializeToForum('telegramNotifyButtonText', 'telegram-notify.button_text'),

    
    (new Extend\Frontend('admin'))
        ->js(__DIR__.'/js/dist/admin.js'),
        
      (new Extend\Settings())
        ->serializeToForum('telegramNotifySettings', SettingsModal::class),


    (new Extend\Event())
        ->listen(\Flarum\Post\Event\Posted::class, Yusiqo\TgNotify\Listeners\PostCreatedListener::class),
];
