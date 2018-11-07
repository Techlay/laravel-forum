@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1 class="display-4">
                    {{ $profileUser->name }}
                    <small>Since {{ $profileUser->created_at->diffForHumans() }}</small>
                </h1>

                @can('update', $profileUser)
                    <form method="POST" action="{{ route('avatar', $profileUser) }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="file" name="avatar">

                        <button type="submit">Add Avatar</button>
                    </form>
                @endcan

                <img src="{{ asset($profileUser->avatar_path) }}" width="50" height="50">
                <hr>
                @forelse($activities as $date => $activity)
                    <h3>{{ $date }}</h3>
                    @foreach($activity as $record)
                        @if(view()->exists("profiles.activities.{$record->type}"))
                            @include("profiles.activities.{$record->type}", ['activity' => $record])
                        @endif
                    @endforeach
                @empty
                    <p>There is no activity for this user yet.</p>
                @endforelse
                <br>
            </div>
        </div>
    </div>
@endsection