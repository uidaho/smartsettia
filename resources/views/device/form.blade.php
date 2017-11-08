<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}" id="form_group_device_name">
	{!! Form::label('name', 'Name', ['class' => 'col-sm-3 control-label']) !!}
	<div class="col-sm-9">
		{!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required', 'id' => 'input_device_name']) !!}
		<small class="text-danger" id="error_device_name">{{ $errors->first('name') }}</small>
		<span class="help-block">Name that will identify the device.</span>
	</div>
</div>

<div class="form-group{{ $errors->has('site_id') ? ' has-error' : '' }} {{ $errors->has('new_site_name') ? ' has-error' : '' }}" id="form_group_site">
	{!! Form::label('site_id', 'Site', ['class' =>'col-sm-3 control-label']) !!}
	<div class="col-sm-9">
		@if (!$sites->isEmpty())
			<select class="form-control" name="site_id" id="site_id">
				@foreach($sites as $site)
					<option value="{{ $site->id }}">{{ $site->name }}</option>
				@endforeach
				<option value="">Create new site</option>
			</select>
			<input class="form-control" style="display: none" name="new_site_name" placeholder="eg: Sixth Street Greenhouse" id="new_site_name">
		@else
			<input class="form-control" name="new_site_name" placeholder="eg: Sixth Street Greenhouse" id="new_site_name">
		@endif
		<small class="text-danger" id="error_site">{{ $errors->first('site_id') }}{{ $errors->first('new_site_name') }}</small>
		<span class="help-block">Single site the device belongs to.</span>
	</div>
</div>

<div class="form-group{{ $errors->has('location_id') ? ' has-error' : '' }} {{ $errors->has('new_location_name') ? ' has-error' : '' }}" id="form_group_location">
	{!! Form::label('location_id', 'Location', ['class' => 'col-sm-3 control-label']) !!}
	<div class="col-sm-9">
		@if (!$locations->isEmpty())
			<select class="form-control" name="location_id" id="location_id">
					@foreach($locations as $location)
						<option value="{{ $location->id }}">{{ $location->name }}</option>
					@endforeach
					<option value="">Create new location</option>
			</select>
			<input class="form-control" style="display: none" name="new_location_name" placeholder="eg: Green House 1A" id="new_location_name">
		@else
			<select class="form-control" name="location_id" id="location_id" style="display: none">
			</select>
			<input class="form-control" name="new_location_name" placeholder="eg: Green House 1A" id="new_location_name">
		@endif
		<small class="text-danger" id="error_location">{{ $errors->first('location_id') }}{{ $errors->first('new_location_name') }}</small>
		<span class="help-block">Single location the device belongs to.</span>
	</div>
</div>

<div class="form-group{{ $errors->has('open_time') ? ' has-error' : '' }}" id="form_group_open_time">
	{!! Form::label('open_time', 'Open Time', ['class' => 'col-sm-3 control-label']) !!}
	<div class="col-sm-9">
		<input class="form-control" required="required" name="open_time" type="time" value="{{ $device->open_time ?? '07:00' }}" id="open_time">
		<small class="text-danger" id="error_open_time">{{ $errors->first('open_time') }}</small>
		<span class="help-block">Local time the device should open each day.</span>
	</div>
</div>

<div class="form-group{{ $errors->has('close_time') ? ' has-error' : '' }}" id="form_group_close_time">
	{!! Form::label('close_time', 'Close Time', ['class' => 'col-sm-3 control-label']) !!}
	<div class="col-sm-9">
		<input class="form-control" required="required" name="close_time" type="time" value="{{ $device->close_time ?? '20:00' }}" id="close_time">
		<small class="text-danger" id="error_close_time">{{ $errors->first('close_time') }}</small>
		<span class="help-block">Local time the device should close each day.</span>
	</div>
</div>

<div class="form-group{{ $errors->has('update_rate') ? ' has-error' : '' }}" id="form_group_update_rate">
	{!! Form::label('update_rate', 'Update Rate', ['class' => 'col-sm-3 control-label']) !!}
	<div class="col-sm-9">
		{!! Form::number('update_rate', null, ['class' => 'form-control', 'required' => 'required']) !!}
		<small class="text-danger" id="error_update_rate">{{ $errors->first('update_rate') }}</small>
		<span class="help-block">Interval the device posts and gets configuration data in seconds.</span>
	</div>
</div>

<div class="form-group{{ $errors->has('image_rate') ? ' has-error' : '' }}" id="form_group_image_rate">
	{!! Form::label('image_rate', 'Image Rate', ['class' => 'col-sm-3 control-label']) !!}
	<div class="col-sm-9">
		{!! Form::number('image_rate', null, ['class' => 'form-control', 'required' => 'required']) !!}
		<small class="text-danger" id="error_image_rate">{{ $errors->first('image_rate') }}</small>
		<span class="help-block">Interval the device posts images in seconds.</span>
	</div>
</div>

<div class="form-group{{ $errors->has('sensor_rate') ? ' has-error' : '' }}" id="form_group_sensor_rate">
	{!! Form::label('sensor_rate', 'Sensor Rate', ['class' => 'col-sm-3 control-label']) !!}
	<div class="col-sm-9">
		{!! Form::number('sensor_rate', null, ['class' => 'form-control', 'required' => 'required']) !!}
		<small class="text-danger" id="error_sensor_rate">{{ $errors->first('sensor_rate') }}</small>
		<span class="help-block">Interval the device posts sensor data in seconds.</span>
	</div>
</div>