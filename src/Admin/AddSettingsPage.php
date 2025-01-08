<?php

namespace Yusiqo\TgNotify\Admin;

use Flarum\Extend\Frontend;
use Flarum\Frontend\Document;

class AddSettingsPage
{
    public function __invoke(Document $document)
    {
        $document->payload['settings'] = [
            'bot_token' => app('flarum.settings')->get('telegram-notify.bot_token'),
            'chat_id' => app('flarum.settings')->get('telegram-notify.chat_id'),
        ];
    }
}
