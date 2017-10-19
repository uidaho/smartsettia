<div class="form-group{{ $errors->has('site_id') ? ' has-error' : '' }}">
	{!! Form::label('site_id', 'Site ID', ['class' => 'col-sm-3 control-label']) !!}
	<div class="col-sm-9">
		{!! Form::text('site_id', null, ['class' => 'form-control', 'required' => 'required']) !!}
		<small class="text-danger">{{ $errors->first('site_id') }}</small>
		<span class="help-block">Site the location belongs to.</span>
	</div>
</div>
<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
	{!! Form::label('name', 'Name', ['class' => 'col-sm-3 control-label']) !!}
	<div class="col-sm-9">
		{!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
		<small class="text-danger">{{ $errors->first('name') }}</small>
		<span class="help-block">Name of the location.</span>
	</div>
</div>