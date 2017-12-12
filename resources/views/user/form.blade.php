<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
    {!! Form::label('name', 'Name', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
        <small class="text-danger">{{ $errors->first('name') }}</small>
        <span class="help-block">Your first and last name.</span>
    </div>
</div>
<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
    {!! Form::label('email', 'Email address', ['class' =>'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::email('email', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'eg: foo@bar.com']) !!}
        <small class="text-danger">{{ $errors->first('email') }}</small>
        <span class="help-block">E-mail address that alerts and password resets will be sent to.</span>
    </div>
</div>
<div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
    {!! Form::label('phone', 'Phone number', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('phone', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('phone') }}</small>
        <span class="help-block">Phone number text alerts will be sent to.</span>
    </div>
</div>
<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
    {!! Form::label('password', 'Password', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::password('password', ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('password') }}</small>
        </div>
</div>
<div class="form-group{{ $errors->has('password-confirm') ? ' has-error' : '' }}">
    {!! Form::label('password-confirm', 'Confirm Password', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::password('password-confirm', ['class' => 'form-control', 'name' => 'password_confirmation']) !!}
            <small class="text-danger">{{ $errors->first('password-confirm') }}</small>
            <span class="help-block">Choose a long password that is not used anywhere else.</span>
        </div>
</div>
@can('updateRole', $user ?? new App\User)
	<div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
		{!! Form::label('role', 'User Role', ['class' => 'col-sm-3 control-label']) !!}
			<div class="col-sm-9">
				{!! Form::select('role', [0 => 'Registered - No access', 1 => 'User - Can control units', 2 => 'Manager - Can modify units and users', 3 => 'Admin - Can create managers'], null, ['placeholder' => 'Pick a role...', 'class' => 'form-control', 'name' => 'role', 'required' => 'required']) !!}
				<small class="text-danger">{{ $errors->first('role') }}</small>
				<span class="help-block">Role for this user that limits access to features.</span>
			</div>
	</div>
@endcan