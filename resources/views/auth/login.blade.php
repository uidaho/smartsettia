@extends('layouts.home')

@section('title', 'Login')

@section('content')
	<div class="register-photo">
		<div class="form-container">
			<div class="image-holder"></div>
			{!! Form::open(['route' => 'login', 'method' => 'post', 'class' => 'form-horizontal']) !!}
                {{ csrf_field() }}
				<h2>Log in</h2>

				<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
				    {!! Form::label('email', 'Email address', ['class' =>'col-sm-3 control-label']) !!}
				    <div class="col-sm-9">
				        {!! Form::email('email', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'eg: foo@bar.com']) !!}
				        <small class="text-danger">{{ $errors->first('email') }}</small>
				    </div>
				</div>

				<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
				    {!! Form::label('password', 'Password', ['class' => 'col-sm-3 control-label']) !!}
				        <div class="col-sm-9">
				            {!! Form::password('password', ['class' => 'form-control', 'required' => 'required']) !!}
				            <small class="text-danger">{{ $errors->first('password') }}</small>
				        </div>
				</div>

				<div class="form-group">
				    <div class="col-sm-offset-3 col-sm-9">
				        <div class="checkbox{{ $errors->has('remember') ? ' has-error' : '' }}">
				            <label for="remember">
				                {!! Form::checkbox('remember', null, null, ['id' => 'remember']) !!} Remember Me
				            </label>
				        </div>
				        <small class="text-danger">{{ $errors->first('remember') }}</small>
				    </div>
				</div>

                <div class="form-group">
                    <div class="col-xs-offset-3 col-xs-9">
						{!! Form::submit('Login', ['class' => 'btn btn-info pull-right']) !!}
                        <p><a class="margin-top-4" href="{{ route('password.request') }}">Forgot Your Password?</a></p>
                    </div>
                </div>
            {!! Form::close() !!}
		</div>
	</div>
@endsection


<div class="form-group{{ $errors->has('inputname') ? ' has-error' : '' }}">
    {!! Form::label('inputname', 'Input', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('inputname', null, ['class' => 'form-control', 'required' => 'required']) !!}
        <small class="text-danger">{{ $errors->first('inputname') }}</small>
    </div>
</div>
