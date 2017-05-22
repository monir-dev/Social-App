@extends('templates.default')

@section('content')

    <h3>Sign up</h3>
    <div class="row">
        <div class="col-lg-6">
            <form class="form-vertical" role="form" action="{{ route('auth.signup') }}" method="post">

                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    <label for="email" class="control-label">Your email address</label>
                    <input type="text" name="email" class="form-control" id="email" value="{{ Request::old('email') ?: '' }}">
                    @if ($errors->has('email'))
                        <span class="help-block"></span>{{ $errors->first('email') }}
                    @endif
                </div>
                <div class="form-group {{ $errors->has('username') ? 'has-error' : '' }}">
                    <label for="username" class="control-label">Chooser your username</label>
                    <input type="text" name="username" class="form-control" id="username" value="{{ Request::old('username') ?: '' }}">
                    @if ($errors->has('username'))
                        <span class="help-block"></span>{{ $errors->first('username') }}
                    @endif
                </div>
                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                    <label for="password" class="control-label">Choose your password</label>
                    <input type="password" name="password" class="form-control" id="password">
                    @if ($errors->has('password'))
                        <span class="help-block"></span>{{ $errors->first('password') }}
                    @endif
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-default">Sign Up</button>
                </div>
                <input type="hidden" name="_token" value="{{ Session::token() }}">
            </form>
        </div>
    </div>

@endsection
