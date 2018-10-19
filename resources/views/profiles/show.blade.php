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
                @foreach($activities as $date => $activity)
                    <h3>{{ $date }}</h3>
                    @foreach($activity as $record)
                        @include("profiles.activities.{$record->type}", ['activity' => $record])
                    @endforeach
                @endforeach
                <br>
{{--                {{ $threads->links() }}--}}
            </div>
        </div>
    </div>
@endsection