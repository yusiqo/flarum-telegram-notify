<?php

use Flarum\Extend;
use TelegramNotify\Listeners\PostCreatedListener;
use TelegramNotify\Admin\AddSettingsPage;

return [
    (new Extend\Event())
        ->listen(\Flarum\Post\Event\Posted::class, PostCreatedListener::class),

    (new Extend\Frontend('admin'))
        ->content(AddSettingsPage::class),

    (new Extend\Settings())
        ->serializeToForum('telegram-notify.bot_token', 'telegram-notify.bot_token')
        ->serializeToForum('telegram-notify.chat_id', 'telegram-notify.chat_id'),
];
