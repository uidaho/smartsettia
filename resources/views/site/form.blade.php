<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
	{!! Form::label('name', 'Name', ['class' => 'col-sm-3 control-label']) !!}
	<div class="col-sm-9">
		{!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => "eg: Sixth Street Greenhouse"]) !!}
		<small class="text-danger">{{ $errors->first('name') }}</small>
		<span class="help-block">Name of the site.</span>
	</div>
</div>