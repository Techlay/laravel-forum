@extends('admin.layout.app')

@section('administration-content')
    <p><a class="btn btn-sm btn-primary" href="{{ route('admin.channels.create') }}">New Channel</a></p>

    <table class="table">
        <thread>
            <tr>
                <th>Name</th>
                <th>Slug</th>
                <th>Description</th>
                <th>Threads</th>
                <th>Actions</th>
            </tr>
        </thread>
        <tbody>
        @forelse($channels as $channel)
            <tr class="{{ $channel->archived ? 'table-danger' : '' }}">
                <td>{{ $channel->name }}</td>
                <td>{{ $channel->slug }}</td>
                <td>{{ $channel->description }}</td>
                <td>{{ $channel->threads()->count() }}</td>
                <td>
                    <a href="{{ route('admin.channels.edit', ['channel' => $channel->slug]) }}" class="btn btn-sm btn-outline-dark">Edit</a>
                </td>
            </tr>
        @empty
            <tr>
                <td>Nothing here.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endsection
