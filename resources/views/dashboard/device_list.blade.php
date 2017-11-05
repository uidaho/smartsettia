<div class="table-bordered" style="max-height: 400px; overflow:auto;">
	<table class="table table-striped table-responsive" style="margin-bottom: 0;">
		<thead>
		<tr>
			<th>Name</th>
			<th>Controls</th>
		</tr>
		</thead>
		<tbody id="control_devices_list">
		@foreach ($devices as $device)
			<tr id="tr_{{ $device->id }}">
				<td>{{ $device->name }}</td>
				<td>
					<div class="btn-group btn-group-sm" role="group" style="display: block">
						@if($device->id == $active_data['device']['id'])
							<button class="btn btn-primary" type="button" data-view="{{ $loop->index }}" data-device-id="{{ $device->id }}" disabled><i class="fa fa-video-camera"></i> View</button>
						@else
							<button class="btn btn-primary" type="button" data-view="{{ $loop->index }}" data-device-id="{{ $device->id }}"><i class="fa fa-video-camera"></i> View</button>
						@endif
						@switch($device->actualCoverStatus())
							@case('open')
								<button class="btn btn-primary" type="button" data-array-pos="{{ $loop->index }}" data-device-id="{{ $device->id }}" data-command="close"><i class="glyphicon glyphicon-resize-small"></i> Close</button>
								@break
							@case('opening')
								<button class="btn btn-primary" type="button" data-array-pos="{{ $loop->index }}" data-device-id="{{ $device->id }}" disabled><i class="fa fa-cog fa-spin fa-fw" aria-hidden="true"></i> Opening</button>
								@break
							@case('closed')
								<button class="btn btn-primary" type="button" data-array-pos="{{ $loop->index }}" data-device-id="{{ $device->id }}" data-command="open"><i class="glyphicon glyphicon-resize-full"></i> Open</button>
								@break
							@case('closing')
								<button class="btn btn-primary" type="button" data-array-pos="{{ $loop->index }}" data-device-id="{{ $device->id }}" disabled><i class="fa fa-cog fa-spin fa-fw" aria-hidden="true"></i> Closing</button>
								@break
							@case('locked')
								<button class="btn btn-primary" type="button" data-array-pos="{{ $loop->index }}" data-device-id="{{ $device->id }}" disabled><i class="fa fa-lock" aria-hidden="true"></i> Locked</button>
								@break
							@default
								<button class="btn btn-primary" type="button" data-array-pos="{{ $loop->index }}" data-device-id="{{ $device->id }}" disabled><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error</button>
						@endswitch
						<button class="btn btn-primary" type="button" disabled><i class="fa fa-line-chart"></i> Graphs</button>
						@if($device->actualCoverStatus() == 'locked')
							<button class="btn btn-primary" type="button" data-array-pos="{{ $loop->index }}" data-device-id="{{ $device->id }}" data-command="unlock"><i class="fa fa-unlock" aria-hidden="true"></i> Unlock</button>
						@elseif($device->actualCoverStatus() == 'open' || $device->actualCoverStatus() == 'closed')
							<button class="btn btn-primary" type="button" data-array-pos="{{ $loop->index }}" data-device-id="{{ $device->id }}" data-command="lock"><i class="fa fa-lock" aria-hidden="true"></i> Lock</button>
						@else
							<button class="btn btn-primary" type="button" data-array-pos="{{ $loop->index }}" data-device-id="{{ $device->id }}" disabled><i class="fa fa-lock" aria-hidden="true"></i> Lock</button>
						@endif
						<button class="btn btn-primary" type="button" data-toggle="modal" data-target="#editDeviceModal" data-edit="{{ $loop->index }}" data-device-id="{{ $device->id }}"><i class="glyphicon glyphicon-edit"></i> Edit</button>
					</div>
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
</div>
<div id="pagination_links">
	{{ $devices->appends(['site_id' => $active_data['site']['id'], 'location_id' => $active_data['location']['id']])->links() }}
</div>