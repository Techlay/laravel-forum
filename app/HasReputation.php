<?php

namespace App;

trait HasReputation
{
    /**
     * Award reputation points to the model.
     *
     * @param  string $action
     */
    public function gainReputation($action)
    {
        $this->increment('reputation', config("forum.reputation.{$action}"));
    }

    /**
     * Reduce reputation points for the model.
     *
     * @param  string $action
     */
    public function loseReputation($action)
    {
        $this->decrement('reputation', config("forum.reputation.{$action}"));
    }
}
