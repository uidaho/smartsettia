@extends('layouts.home')

@section('title', 'Login')

@section('content')
	<div class="register-photo">
		<div class="form-container">
			<div class="image-holder"></div>
			<form method="POST" action="{{ route('login') }}" class="form-horizontal">
                {{ csrf_field() }}
				<h2>Log in</h2>

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="col-xs-3 control-label">Email</label>
					<div class="col-xs-9">
						<input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
	                    @if ($errors->has('email'))
	                        <span class="help-block">
	                            <strong>{{ $errors->first('email') }}</strong>
	                        </span>
	                    @endif
					</div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password" class="col-xs-3 control-label">Password</label>
                    <div class="col-xs-9">
						<input id="password" type="password" class="form-control" name="password" required>
	                    @if ($errors->has('password'))
	                        <span class="help-block">
	                            <strong>{{ $errors->first('password') }}</strong>
	                        </span>
	                    @endif
					</div>
                </div>

                <div class="form-group">
					<div class="col-xs-offset-3 col-xs-9">
						<div class="checkbox">
							<label>
								<input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
							</label>
						</div>
					</div>
                </div>

                <div class="form-group">
                    <div class="col-xs-offset-3 col-xs-9">
                        <button type="submit" class="btn btn-primary">Login</button>
                        <p><a class="margin-top-4" href="{{ route('password.request') }}">Forgot Your Password?</a></p>
                    </div>
                </div>
            </form>
		</div>
	</div>
@endsection
