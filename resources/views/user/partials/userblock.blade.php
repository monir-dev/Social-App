<div class="media">
    <a class="pull-left" href="{{ route('profile.index', $user->username) }}">
        <img class="media-object" src="{{ $user->getAvaterUrl() }}" alt="{{ $user->getNameOrUsername() }}">
    </a>
    <div class="media-body">
        <h4 class="media-heading"><a href="{{ route('profile.index', $user->username) }}">{{ $user->getNameOrUsername() }}</a></h4>
        @if ($user->location)
            <p>{{ $user->location }}</p>
        @endif
    </div>
</div>
