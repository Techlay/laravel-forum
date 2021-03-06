<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MentionUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function mentioned_users_in_a_thread_are_notified()
    {
        $john = create('App\User', ['username' => 'JohnDoe']);

        $this->signIn($john);

        $jane = create('App\User', ['username' => 'JaneDoe']);

        $thread = make('App\Thread', [
            'body' => 'Hey @JaneDoe check this out.'
        ]);

        $this->post(route('threads'), $thread->toArray());

        $this->assertCount(1, $jane->notifications);

        $this->assertEquals(
            "JohnDoe mentioned you in \"{$thread->title}\"",
            $jane->notifications->first()->data['message']
        );
    }

    /** @test */
    public function mentioned_users_in_a_reply_are_notified()
    {
        $john = create('App\User', ['username' => 'JohnDoe']);

        $this->signIn($john);

        $jane = create('App\User', ['username' => 'JaneDoe']);

        $thread = create('App\Thread');

        $reply = make('App\Reply', [
            'body' => '@JaneDoe check this out'
        ]);

        $this->json('post', $thread->path() . '/replies', $reply->toArray());

        $this->assertCount(1, $jane->notifications);

        $this->assertEquals(
            "JohnDoe mentioned you in \"{$thread->title}\"",
            $jane->notifications->first()->data['message']
        );
    }

    /** @test */
    public function it_can_fetch_all_mentioned_users_starting_with_the_given_characters()
    {
        create('App\User', ['username' => 'johndoe']);
        create('App\User', ['username' => 'johndoe2']);
        create('App\User', ['username' => 'janedoe']);

        $results = $this->json('GET', '/api/users', ['username' => 'john']);

        $this->assertCount(2, $results->json());
    }
}
