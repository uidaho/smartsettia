<!-- Modal -->
<div class="modal fade" id="editDeviceModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Edit Device</h4>
			</div>
			<div class="modal-body">
				{!! Form::model($device, ['route' => ['device.update', $device->id], 'method' => 'put', 'class' => 'form-horizontal', 'id' => 'form_edit_device']) !!}
				{!! Form::hidden('from', 'modal') !!}
				<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
					{!! Form::label('name', 'Name', ['class' => 'col-sm-3 control-label']) !!}
					<div class="col-sm-9">
						{!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required', 'id' => 'input_device_name']) !!}
						<small class="text-danger">{{ $errors->first('name') }}</small>
					</div>
				</div>

				<div class="form-group{{ $errors->has('site') ? ' has-error' : '' }} {{ $errors->has('new_site_name') ? ' has-error' : '' }}">
					{!! Form::label('site', 'Site', ['class' =>'col-sm-3 control-label']) !!}
					<div class="col-sm-9">
						@if ($sites)
							<select class="form-control" name="site" id="site">
								@if (!$locations)
									<option value="-1">Choose a site</option>
								@endif
								@foreach($sites as $site)
									<option value="{{ $site->id }}">{{ $site->name }}</option>
								@endforeach
								<option value="">Create new site</option>
							</select>
						@endif
						<input class="form-control" style="display: none" name="new_site_name" placeholder="eg: Sixth Street Greenhouse" id="new_site_name">
						<small class="text-danger">{{ $errors->first('site') }}</small>
						<small class="text-danger">{{ $errors->first('new_site_name') }}</small>
					</div>
				</div>

				<div class="form-group{{ $errors->has('location') ? ' has-error' : '' }} {{ $errors->has('new_location_name') ? ' has-error' : '' }}">
					{!! Form::label('location', 'Location', ['class' => 'col-sm-3 control-label']) !!}
					<div class="col-sm-9">
						<select class="form-control" name="location" id="location">
							@if ($locations)
								@foreach($locations as $location)
									<option value="{{ $location->id }}">{{ $location->name }}</option>
								@endforeach
								<option value="">Create new location</option>
							@else
								<option value="">Choose a site first</option>
							@endif
						</select>
						<input class="form-control" style="display: none" name="new_location_name" placeholder="eg: Green House 1A" id="new_location_name">
						<small class="text-danger">{{ $errors->first('location') }}</small>
						<small class="text-danger">{{ $errors->first('new_location_name') }}</small>
					</div>
				</div>
				{!! Form::close() !!}
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button class="btn btn-primary" type="submit" form="form_edit_device">Save changes</button>
			</div>
		</div>
	</div>
</div>