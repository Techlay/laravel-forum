@forelse ($threads as $thread)

    <div class="card">
        <div class="card-header">
            <div class="level">
                <div class="flex">
                    <div>
                        <a href="{{ $thread->path() }}">
                            @if($thread->pinned)
                                <i class="fas fa-thumbtack"></i>
                            @endif
                            @if(auth()->check() && $thread->hasUpdatesFor(auth()->user()))
                                <strong>
                                    {{ $thread->title }}
                                </strong>
                            @else
                                {{ $thread->title }}
                            @endif
                        </a>
                    </div>

                    <div>Posted By:
                        <a href="{{ route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a>
                    </div>
                </div>

                <a href="{{ $thread->path() }}">
                    {{ $thread->replies_count }} {{ str_plural('reply', $thread->replies_count) }}
                </a>
            </div>
        </div>

        <div class="card-body">
            <thread-view :thread="{{ $thread }}" inline-template>
                <highlight :content="body"></highlight>
            </thread-view>
        </div>

        <div class="card-footer">
            {{ $thread->visits }} Visits
        </div>
    </div>
    <br>
@empty
    <p>There are no relevant results at this time.</p>
@endforelse
