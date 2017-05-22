@extends('templates.default')

@section('content')
    <div class="row">
        <div class="col-lg-5">
            <!-- User information and status -->
            @include('user.partials.userblock')
            <hr>

            @if (!$statuses->count())
                <p>{{ $user->getFirstNameOrUsername() }} hasn't posted anything yet.</p>
            @else
                @foreach ($statuses as $status)
                    <div class="media">
                        <a class="pull-left" href="{{ route('profile.index', ['username' => $status->user->username]) }}">
                            <img class="media-object" src="{{ $status->user->getAvaterUrl() }}" alt="{{ $status->user->getNameOrUsername() }}">
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading"><a href="{{ route('profile.index', ['username' => $status->user->username]) }}">
                              {{ $status->user->getNameOrUsername() }}</a></h4>
                            <p>{{ $status->body }}</p>
                            <ul class="list-inline">
                                <li>{{ $status->created_at->diffForHumans() }}</li>
                                @if ($status->user->id !== Auth::user()->id)
                                    <li><a href="{{ route('status.like', ['statusId' => $status->id]) }}">like</a></li>
                                @endif
                                <li>{{ $status->likes->count() }} {{ str_plural('like', $status->likes->count()) }}</li>
                            </ul>

                            @foreach ($status->replies as $reply)
                                <div class="media">
                                    <a class="pull-left" href="{{ route('profile.index', ['username' => $reply->user->username]) }}">
                                        <img class="media-object" src="{{ $reply->user->getAvaterUrl() }}" alt="{{ $reply->user->getNameOrUsername() }}">
                                    </a>
                                    <div class="media-body">
                                        <h5 class="media-heading"><a href="{{ route('profile.index', ['username' => $reply->user->username]) }}">{{ $reply->user->getNameOrUsername() }}</a></h5>
                                        <p>{{ $reply->body }}</p>
                                        <ul class="list-inline">
                                            <li>{{ $reply->created_at->diffForHumans() }}</li>
                                            @if ($reply->user->id !== Auth::user()->id)
                                                <li><a href="{{ route('status.like', ['statusId' => $reply->id]) }}">like</a></li>
                                            @endif
                                            <li>{{ $reply->likes->count() }} {{ str_plural('like', $reply->likes->count()) }}</li>
                                        </ul>
                                    </div>
                                </div>
                            @endforeach

                            @if ($authUserIsFriend || Auth::user()->id === $status->user->id)
                              <form role="form" action="{{ route('status.reply', ['stausId' => $status->id]) }}" method="post">
                                  <div class="form-group {{ $errors->has("reply-{$status->id}") ? 'has-error' : '' }}">
                                      <textarea name="reply-{{ $status->id }}" class="form-control" placeholder="Reply to this status" rows="2"></textarea>
                                      @if ($errors->has("reply-{$status->id}"))
                                        <span class="help-block">{{ $errors->first("reply-{$status->id}") }}</span>
                                      @endif
                                  </div>
                                  <input type="submit" name="" value="reply" class="btn btn-default btn-sm">
                                  {{ csrf_field() }}
                              </form>
                            @endif

                        </div>
                    </div>
                @endforeach
            @endif

        </div>
        <div class="col-lg-4 col-lg-offset-3">
            <!-- Friends, friend requests  -->
            @if (Auth::user()->hasFriendRequestPending($user))
                <p>Waiting for {{ $user->getNameOrUsername() }} to accept your request.</p>
            @elseif(Auth::user()->hasFriendRequestReceived($user))
                <a href="{{ route('friend.accept', ['username' => $user->username]) }}" class="btn btn-primary">Accept friend request.</a>
            @elseif(Auth::user()->isFriendsWith($user))
                <p>you and {{ $user->getNameOrUsername() }} are friends.</p>
                <form role="form" action="{{ route('friend.delete', ['ussename' => $user->username]) }}" method="post">
                    <input type="submit" name="" value="Delete friend" class="btn btn-danger">
                    {{ csrf_field() }}
                </form>
            @elseif(Auth::user()->id !== $user->id)
                <a href="{{ route('friend.add', ['username' => $user->username]) }}" class="btn btn-primary">Add as friends</a>
            @endif

            <h4>{{ $user->getFirstNameOrUsername() }}'s friends</h4>

            @if (!$user->friends()->count())
                <p>{{ $user->getFirstNameOrUsername() }} has no friends</p>
            @else
                @foreach ($user->friends() as $user)
                    @include('user/partials/userblock')
                @endforeach
            @endif
        </div>
    </div>
@endsection
