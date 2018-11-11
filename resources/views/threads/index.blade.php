@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            @include('threads._list')

            {{ $threads->render() }}
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Search
                </div>

                <div class="card-body">
                    <form method="GET" action="/threads/search" class="form-group" >
                        <div class="form-group">
                            <input type="text" placeholder="Search for something..." name="q" class="form-control">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
