<?php

use Flarum\Extend;
use Flarum\Settings\SettingsRepositoryInterface;

return [
    (new Extend\Settings())
        ->serializeToForum('telegramNotifyBotToken', 'telegram-notify.bot_token')
        ->serializeToForum('telegramNotifyChatId', 'telegram-notify.chat_id')
        ->serializeToForum('telegramNotifyMessageTemplate', 'telegram-notify.message_template')
        ->serializeToForum('telegramNotifyButtonText', 'telegram-notify.button_text'),

    (new Extend\Event())
        ->listen(\Flarum\Post\Event\Posted::class, \TelegramNotify\Listeners\PostCreatedListener::class),
];
