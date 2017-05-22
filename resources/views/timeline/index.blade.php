@extends('templates.default')

@section('content')

    <div class="row">
        <div class="col-lg-6">
            <form role="form" action="{{ route('status.post') }}" method="post">
                {{ csrf_field() }}
                <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                    <textarea placeholder="What's up {{ Auth::user()->getFirstnameOrUsername() }}?" name="status" class="form-control" rows="2"></textarea>
                    @if ($errors->has('status'))
                        <span class="help-block">{{ $errors->first('status') }}</span>
                    @endif
                </div>
                <button type="submit" class="btn btn-default">Update status</button>
            </form>
            <hr>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <!-- timeline statuses and replies -->
            @if (!$statuses->count())
                <p>There's nothing in your timeline, yet</p>
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
                        </div>
                    </div>
                @endforeach
                        {!! $statuses->links() !!}
            @endif
        </div>
    </div>
@endsection
