<?php

namespace App\Http\Controllers\Admin;

use App\Channel;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class ChannelController extends Controller
{
    /**
     * Show all channels.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $channels = Channel::withoutGlobalScopes()->orderBy('name', 'asc')->withCount('threads')->get();

        return view('admin.channels.index', compact('channels'));
    }

    /**
     * Show the form to create a new channel
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.channels.create', ['channel' => new Channel]);
    }

    /**
     * Show the form to edit an existing channel.
     *
     * @param Channel $channel
     * @return \Illuminate\Http\Response
     */
    public function edit(Channel $channel)
    {
        return view('admin.channels.edit', compact('channel'));
    }

    /**
     * Update an existing channel.
     *
     * @param Channel $channel
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function update(Channel $channel)
    {
        $channel->update(
            request()->validate([
                'name' => ['required', Rule::unique('channels')->ignore($channel->id)],
                'description' => 'required',
                'colour' => 'required',
                'archived' => 'required|boolean'
            ])
        );

        cache()->forget('channels');

        if (request()->wantsJson()) {
            return response($channel, 200);
        }

        return redirect(route('admin.channels.index'))
            ->with('flash', 'Your channel has been updated!');
    }

    /**
     * Store a new channel.
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function store()
    {
        $channel = Channel::create(
            request()->validate([
                'name' => 'required|unique:channels',
                'colour' => 'required',
                'description' => 'required'
            ])
        );

        cache()->forget('channels');

        if (request()->wantsJson()) {
            return response($channel, 201);
        }

        return redirect(route('admin.channels.index'))
            ->with('flash', 'Your channel has been created!');
    }
}
