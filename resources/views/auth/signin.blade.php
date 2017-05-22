@extends('templates.default')

@section('content')

    <h3>Sign in</h3>
    <div class="row">
        <div class="col-lg-6">
            <form class="form-vertical" role="form" action="{{ route('auth.signin') }}" method="post">

                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    <label for="email" class="control-label">Email:</label>
                    <input type="text" name="email" class="form-control" id="email" value="{{ Request::old('email') ?: '' }}">
                    @if ($errors->has('email'))
                        <span class="help-block"></span>{{ $errors->first('email') }}
                    @endif
                </div>
                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                    <label for="password" class="control-label">Password:</label>
                    <input type="password" name="password" class="form-control" id="password">
                    @if ($errors->has('password'))
                        <span class="help-block"></span>{{ $errors->first('password') }}
                    @endif
                </div>
                <div class="checkbox">
                    <label for="username" class="control-label">
                        <input type="checkbox" name="remember"> Remember me
                    </label>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-default">Sign in</button>
                </div>
                <input type="hidden" name="_token" value="{{ Session::token() }}">
            </form>
        </div>
    </div>

@endsection
