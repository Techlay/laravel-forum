<?php

namespace App\Http\Controllers;

use App\Thread;

class PinnedThreadController extends Controller
{
    /**
     * Pin the given thread.
     *
     * @param Thread $thread
     */
    public function store(Thread $thread)
    {
        $thread->update(['pinned' => true]);
    }

    /**
     * Unpin the given thread.
     *
     * @param Thread $thread
     */
    public function destroy(Thread $thread)
    {
        $thread->update(['pinned' => false]);
    }
}
