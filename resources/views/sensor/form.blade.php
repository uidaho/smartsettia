<div class="form-group{{ $errors->has('device_id') ? ' has-error' : '' }}">
	{!! Form::label('device_id', 'Device ID', ['class' => 'col-sm-3 control-label']) !!}
	<div class="col-sm-9">
		{!! Form::text('device_id', null, ['class' => 'form-control', 'required' => 'required']) !!}
		<small class="text-danger">{{ $errors->first('device_id') }}</small>
	</div>
</div>
<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
	{!! Form::label('name', 'Name', ['class' => 'col-sm-3 control-label']) !!}
	<div class="col-sm-9">
		{!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
		<small class="text-danger">{{ $errors->first('name') }}</small>
	</div>
</div>
<div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
	{!! Form::label('type', 'Type', ['class' => 'col-sm-3 control-label']) !!}
	<div class="col-sm-9">
		{!! Form::text('type', null, ['class' => 'form-control', 'required' => 'required']) !!}
		<small class="text-danger">{{ $errors->first('type') }}</small>
	</div>
</div>