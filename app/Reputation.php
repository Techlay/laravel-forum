<?php

namespace App;

class Reputation
{
    const THREAD_WAS_PUBLISHED = 10;
    const REPLY_POSTED = 2;
    const BEST_REPLY_AWARED = 50;
    const REPLY_FAVORITED = 5;

    /**
     * Award reputation points to the given user.
     *
     * @param User $user
     * @param integer $point
     * @return void
     */
    public static function gain($user, $point)
    {
        $user->increment('reputation', $point);
    }

    /**
     * Reduce reputation points to the given user.
     *
     * @param User $user
     * @param integer $point
     * @return void
     */
    public static function lose($user, $point)
    {
        $user->decrement('reputation', $point);
    }
}
