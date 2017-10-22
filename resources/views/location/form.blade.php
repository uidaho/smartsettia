<div class="form-group{{ $errors->has('site') ? ' has-error' : '' }} {{ $errors->has('new_site_name') ? ' has-error' : '' }}" id="form_group_site">
	{!! Form::label('site', 'Site', ['class' =>'col-sm-3 control-label']) !!}
	<div class="col-sm-9">
		@if ($sites)
			<select class="form-control" name="site" id="site">
				@foreach($sites as $site)
					<option value="{{ $site->id }}">{{ $site->name }}</option>
				@endforeach
				<option value="">Create new site</option>
			</select>
		@endif
		<input class="form-control" style="display: none" name="new_site_name" placeholder="eg: Sixth Street Greenhouse" id="new_site_name">
		<small class="text-danger" id="error_site">{{ $errors->first('site') }}{{ $errors->first('new_site_name') }}</small>
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