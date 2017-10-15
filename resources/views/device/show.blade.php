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
                        <div class="col-md-3 col-lg-3 hidden-xs hidden-sm">
                            <img class="img-thumbnail img-responsive"
                                 src="/image/device/{{ $device->id }}"
                                 alt="Device picture">
                        </div>
                        <div class="col-xs-2 col-sm-2 hidden-md hidden-lg">
                            <img class="img-thumbnail img-responsive"
                                 src="/image/device/{{ $device->id }}"
                                 alt="Device picture">
                        </div>
                        <div class="col-md-9 col-lg-9 hidden-xs hidden-sm">
                            <strong>{{ $device->name }}</strong><br>
                            <table class="table table-device-information">
                                <tbody>
                                <tr>
                                    <td>Location:</td>
                                    <td>{{ (is_object($device->location) ? $device->location->name : '') }}</td>
                                </tr>
                                <tr>
                                    <td>Registered:</td>
                                    <td>{{ $device->created_at }}</td>
                                </tr>
                                <tr>
                                    <td>Updated:</td>
                                    <td>{{ $device->updated_at }}</td>
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
                                    <td>Open Switch:</td>
                                    <td>{{ $device->limitsw_open }}</td>
                                </tr>
                                <tr>
                                    <td>Closed Switch:</td>
                                    <td>{{ $device->limitsw_closed }}</td>
                                </tr>
                                <tr>
                                    <td>Timezone:</td>
                                    <td>{{ $device->timezone }}</td>
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
                                    <td>{{ $device->open_time }} GMT</td>
                                </tr>
                                <tr>
                                    <td>Close Time:</td>
                                    <td>{{ $device->close_time }} GMT</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <a class="btn btn-sm btn-primary" type="button" title="E-mail this device" href="mailto:{{ $device->email }}"><i class="glyphicon glyphicon-envelope"></i></a>
                    <span class="pull-right">
                        <a class="btn btn-sm btn-warning" type="button" title="Edit this device" href="\device\{{ $device->id }}\edit"><i class="glyphicon glyphicon-edit"></i></a>
                        <a class="btn btn-sm btn-danger" type="button" title="Remove this device" href="\device\{{ $device->id }}\remove"><i class="glyphicon glyphicon-remove"></i></a>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
@endpush


@push('scripts')
@endpush
