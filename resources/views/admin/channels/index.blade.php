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
            </tr>
        </thread>
        <tbody>
            @forelse($channels as $channel)
                <tr>
                    <td>{{ $channel->name }}</td>
                    <td>{{ $channel->slug }}</td>
                    <td>{{ $channel->description }}</td>
                    <td>{{ count($channel->threads()) }}</td>
                </tr>
            @empty
                <tr>
                    <td>Nothing here.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
