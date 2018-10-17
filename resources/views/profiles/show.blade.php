@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1 class="display-4">
                    {{ $profileUser->name }}
                    <small>Since {{ $profileUser->created_at->diffForHumans() }}</small>
                </h1>
                <hr>
                @foreach($threads as $thread)
                    <div class="card">
                        <div class="card-header">
                            <div class="level">
                                <span class="flex">
                                    <a href="{{ route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a> posted:
                                    <a href="{{ $thread->path() }}">{{ $thread->title }}</a>
                                </span>
                                <span>{{ $thread->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        <div class="card-body">
                            {{ $thread->body }}
                        </div>
                    </div>
                    <br>
                @endforeach
                <br>
                {{ $threads->links() }}
            </div>
        </div>
    </div>
@endsection