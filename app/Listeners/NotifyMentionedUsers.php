<?php

namespace App\Listeners;

use App\Notifications\YouWereMentioned;
use App\User;

class NotifyMentionedUsers
{
    /**
     * Handle the event.
     *
     * @param  mixed $event
     * @return void
     */
    public function handle($event)
    {
        tap($event->subject(), function ($subject) {
            User::whereIn('username', $this->mentionedUsers($subject))
                ->get()->each->notify(new YouWereMentioned($subject));
        });
    }

    /**
     * Fetch all mentioned users within the reply's body.
     *
     * @param $body
     * @return array
     */
    public function mentionedUsers($body)
    {
        preg_match_all('/@([\w\-]+)/', $body, $matches);
        return $matches[1];
    }
}
