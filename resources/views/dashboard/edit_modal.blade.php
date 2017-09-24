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
					<div class="form-group" id="form_group_device_name">
						{!! Form::label('name', 'Name', ['class' => 'col-sm-3 control-label']) !!}
						<div class="col-sm-9">
							{!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required', 'id' => 'input_device_name']) !!}
							<small class="text-danger" id="error_device_name">{{ $errors->first('name') }}</small>
						</div>
					</div>

					<div class="form-group" id="form_group_site">
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
							<small class="text-danger" id="error_site"></small>
						</div>
					</div>

					<div class="form-group" id="form_group_location">
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
							<small class="text-danger" id="error_location"></small>
						</div>
					</div>

					<div class="form-group" id="form_group_open_time">
						{!! Form::label('open_time', 'Open Time', ['class' => 'col-sm-3 control-label']) !!}
						<div class="col-sm-9">
							<input class="form-control" required="required" name="open_time" type="time" value="{{ date("H:i", strtotime($device->open_time)) }}" id="open_time">
							<small class="text-danger" id="error_open_time"></small>
						</div>
					</div>

					<div class="form-group" id="form_group_close_time">
						{!! Form::label('close_time', 'Close Time', ['class' => 'col-sm-3 control-label']) !!}
						<div class="col-sm-9">
							<input class="form-control" required="required" name="close_time" type="time" value="{{ date("H:i", strtotime($device->close_time)) }}" id="close_time">
							<small class="text-danger" id="error_close_time"></small>
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