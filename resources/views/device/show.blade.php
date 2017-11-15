@extends('layouts.dashboard')

@section('title', 'Show Device')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Device information</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 text-center">
                            <input class="img-thumbnail img-responsive center-block" 
                                type="image"
                                src="{{ route('image.device', $device->id) }}"
                                alt="Device Image" id="deviceImage" data-toggle="modal" data-target="#image_modal"/>
                            <a class="no-style-link" href="{{ route('image.device', $device->id) }}" 
                                download="smartsettia-device-{{ $device->id }}_{{ time() }}.jpg" 
                                id="download_image_link">
                                <button class="btn btn-primary">Download Image</button>
                            </a>
                        </div>
                        
                        <div class="col-md-12 col-lg-12">
                            <strong>{{ $device->name }}</strong><br>
                            <table class="table table-device-information">
                                <tbody>
                                <tr>
                                    <td>Site:</td>
                                    <td>
                                        <a href="{{ route('site.show', $device->site->id ?? 0) }}">{{ $device->site->name ?? '' }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Location:</td>
                                    <td>
                                        <a href="{{ route('location.show', $device->location_id ?? 0) }}">{{ is_object($device->location) ? $device->location->name ?? '' : '' }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Registered:</td>
                                    <td>{{ $device->created_at }}</td>
                                </tr>
                                <tr>
                                    <td>Updated:</td>
                                    <td>{{ $device->updatedAtHuman }}</td>
                                </tr>
								<tr>
									<td>Last Communication:</td>
									<td>{{ $device->lastNetworkUpdateAtDetailed }}</td>
								</tr>
                                <tr>
                                    <td>UUID:</td>
                                    <td>{{ $device->uuid }}</td>
                                </tr>
                                <tr>
                                    <td>Token:</td>
                                    <td>{{ $device->token }}</td>
                                </tr>
                                <tr>
                                    <td>Hostname:</td>
                                    <td>{{ $device->hostname }}</td>
                                </tr>
                                <tr>
                                    <td>IP:</td>
                                    <td>{{ $device->ip }}</td>
                                </tr>
                                <tr>
                                    <td>MAC Address:</td>
                                    <td>{{ $device->mac_address }}</td>
                                </tr>
                                <tr>
                                    <td>Time:</td>
                                    <td>{{ $device->time }}</td>
                                </tr>
                                <tr>
                                    <td>Timezone:</td>
                                    <td>{{ $device->timezone }}</td>
                                </tr>
                                <tr>
                                    <td>Error Message:</td>
                                    <td>{{ $device->error_msg }}</td>
                                </tr>
                                <tr>
                                    <td>Update rate:</td>
                                    <td>{{ $device->update_rate }} seconds</td>
                                </tr>
                                <tr>
                                    <td>Image rate:</td>
                                    <td>{{ $device->image_rate }} seconds</td>
                                </tr>
                                <tr>
                                    <td>Sensor rate:</td>
                                    <td>{{ $device->sensor_rate }} seconds</td>
                                </tr>
                                <tr>
                                    <td>Cover status:</td>
                                    <td>{{ $device->cover_status }}</td>
                                </tr>
                                <tr>
                                    <td>Cover command:</td>
                                    <td>{{ $device->cover_command }}</td>
                                </tr>
                                <tr>
                                    <td>Open Time:</td>
                                    <td>{{ $device->openTimeHuman }}</td>
                                </tr>
                                <tr>
                                    <td>Close Time:</td>
                                    <td>{{ $device->closeTimeHuman }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
					<a class="btn btn-sm btn-primary" type="button" title="Go to device list" href="{{ route('device.index') }}"><i class="glyphicon glyphicon-arrow-up"></i></a>
                    <span class="pull-right">
						<a class="btn btn-sm btn-warning" type="button" title="Edit this device" href="{{ route('device.edit', $device->id) }}"><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::open(['method' => 'DELETE', 'route' => ['device.destroy', $device->id], 'style' => 'display:inline', 'onsubmit' => 'return confirm("Are you sure you want to delete this?")']) !!}
                            {!! Form::button('<i class="glyphicon glyphicon-remove"></i>', ['type' => 'submit', 'class' => 'btn btn-sm btn-danger', 'title' => 'Remove this device']) !!}
                        {!! Form::close() !!}
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Device sensors</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <strong>{{ $device->name }}</strong><br>
                            <table class="table table-device-sensors">
                                <thead>
                                    <tr>
                                        <td>Name:</td>
                                        <td>Type:</td>
                                        <td>Value:</td>
                                        <td>Updated At:</td>
                                    </tr>
                                </thead>
                                <tbody>
									@foreach ($device->sensors as $sensor)
                                        <?php $latestData = $sensor->latest_data; ?>
										<tr>
											<td><a href="{{ route('sensor.show', $sensor->id) }}">{{ $sensor->name }}</a></td>
											<td>{{ $sensor->type }}</td>
											<td><a href="{{ route('sensordata.show', $latestData->id ?? 0) }}">{{ $latestData->value ?? 'null' }}</a></td>
											<td>{{ $latestData->updated_at ?? 'null' }} GMT</td>
										</tr>
									@endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Sensor graphs for for last 30 days</h3>
                </div>
                <div class="panel-body">
                    <div class="panel-group" id="accordion">
                        @foreach ($charts as $chart)
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $loop->index }}">{{ $chart->title }}</a>
                                </h4>
                            </div>
                            <div id="collapse{{ $loop->index }}" class="panel-collapse collapse in">
                                <div class="panel-body">
                                    {!! $chart->html() !!}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="panel-footer">
                </div>
            </div>
        </div>
    </div>
</div>
<div id="image_modal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<img class="modal-content" src="{{ route('image.device', $device->id) }}" alt="Device Image">
		<div id="image_caption">{{ $device->name }}</div>
	</div>
</div>
@endsection

@push('styles')
{!! Charts::styles() !!}
@endpush


@push('scripts')
{!! Charts::scripts() !!}
@foreach ($charts as $chart)
{!! $chart->script() !!}
@endforeach
@endpush
