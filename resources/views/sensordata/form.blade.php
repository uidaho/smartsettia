<div class="form-group{{ $errors->has('sensor_id') ? ' has-error' : '' }}">
	{!! Form::label('sensor_id', 'Sensor ID', ['class' => 'col-sm-3 control-label']) !!}
	<div class="col-sm-9">
		{!! Form::text('sensor_id', null, ['class' => 'form-control', 'required' => 'required']) !!}
		<small class="text-danger">{{ $errors->first('sensor_id') }}</small>
	</div>
</div>
<div class="form-group{{ $errors->has('value') ? ' has-error' : '' }}">
	{!! Form::label('value', 'Value', ['class' => 'col-sm-3 control-label']) !!}
	<div class="col-sm-9">
		{!! Form::text('value', null, ['class' => 'form-control', 'required' => 'required']) !!}
		<small class="text-danger">{{ $errors->first('value') }}</small>
	</div>
</div>