<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_records_activity_when_a_thread_is_created()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $this->assertDatabaseHas('activities', [
            'type' => 'created_thread',
            'user_id' => auth()->id(),
            'subject_id' => $thread->id,
            'subject_type' => 'App\Thread'
        ]);

        $activity = \App\Activity::first();

        $this->assertEquals($activity->subject->id, $thread->id);
    }

    /** @test */
    public function it_records_activity_when_a_reply_is_created()
    {
        $this->signIn();

        $reply = create('App\Reply');

        $this->assertEquals(2, \App\Activity::count());
    }

    /** @test */
    public function it_fetches_a_feed_for_any_user()
    {
        $this->signIn();

        create('App\Thread', ['user_id' => auth()->id()], 3);

        auth()->user()->activity()->first()->update(['created_at' => Carbon::now()->subWeek()]);

        $feed = \App\Activity::feed(auth()->user());

        $this->assertCount(3, $feed->all());
        $this->assertEquals([1, 1, 1], $feed->pluck('user_id')->toArray());
    }
}
