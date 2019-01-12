<?php

use App\Reply;
use App\Thread;
use App\Channel;
use App\Activity;
use App\Favorite;
use App\ThreadSubscription;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        $this->channels()->content();

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Seed the channels table.
     */
    protected function channels()
    {
        Channel::truncate();

        collect([
            [
                'name' => 'PHP',
                'description' => 'A channel for general PHP questions. Use this channel if you can\'t find a more specific channel for your question.',
                'colour' => '#008000'
            ],
            [
                'name' => 'Vue',
                'description' => 'A channel for general Vue questions. Use this channel if you can\'t find a more specific channel for your question.',
                'colour' => '#cccccc'
            ],
            [
                'name' => 'JavaScript',
                'description' => 'This channel is for all JavaScript related questions.',
                'colour' => '#43DDF5'
            ],
            [
                'name' => 'Node',
                'description' => 'This channel is for all Node related questions.',
                'colour' => '#a01212'
            ],
            [
                'name' => 'Ruby',
                'description' => 'This channel is for all Ruby related questions.',
                'colour' => '#ff8822'
            ],
            [
                'name' => 'Go',
                'description' => 'This channel is for all Go related questions.',
                'colour' => '#ea4e28'
            ],
            [
                'name' => 'Laravel',
                'description' => 'This channel is for all Laravel related questions.',
                'colour' => '#113a62'
            ],
            [
                'name' => 'Elixir',
                'description' => 'This channel is for all Elixir related questions.',
                'colour' => '#4a245d'
            ],
            [
                'name' => 'Webpack',
                'description' => 'This channel is for all Webpack related questions.',
                'colour' => '#B3CBE6'
            ],
            [
                'name' => 'Symfony',
                'description' => 'This channel is for all Symfony related questions.',
                'colour' => '#091b47'
            ],
            [
                'name' => 'React',
                'description' => 'This channel is for all React related questions.',
                'colour' => '#1E38BB'
            ],
            [
                'name' => 'Java',
                'description' => 'This channel is for all Java related questions.',
                'colour' => '#01476e'
            ],
            [
                'name' => 'AWS',
                'description' => 'This channel is for all AWS related questions.',
                'colour' => '#444444'
            ],

        ])->each(function ($channel) {
            factory(Channel::class)->create([
                'name' => $channel['name'],
                'description' => $channel['description'],
                'colour' => $channel['colour']
            ]);
        });

        return $this;
    }

    /**
     * Seed the thread-related tables.
     */
    protected function content()
    {
        Thread::truncate();
        Reply::truncate();
        ThreadSubscription::truncate();
        Activity::truncate();
        Favorite::truncate();

        factory(Thread::class, 50)->states('from_existing_channels_and_users')->create()->each(function ($thread) {
            $this->recordActivity($thread, 'created', $thread->creator()->first()->id);
        });
    }

    /**
     * @param $model
     * @param $event_type
     * @param $user_id
     *
     * @throws ReflectionException
     */
    public function recordActivity($model, $event_type, $user_id)
    {
        $type = strtolower((new \ReflectionClass($model))->getShortName());

        $model->morphMany(\App\Activity::class, 'subject')->create([
            'user_id' => $user_id,
            'type' => "{$event_type}_{$type}"
        ]);
    }
}
