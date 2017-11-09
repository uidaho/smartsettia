@extends('layouts.dashboard')

@section('title', 'Show Sensor')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Sensor</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <strong>{{ $sensor->name }}</strong><br>
                            <table class="table table-sensor">
                                <tbody>
                                <tr>
                                    <td>ID:</td>
                                    <td>{{ $sensor->id }}</td>
                                </tr>
                                <tr>
                                    <td>Device:</td>
                                    <td><a href="{{ route('device.show', $sensor->device_id) }}">{{ $sensor->device->name ?? 'null' }}</a></td>
                                </tr>
                                <tr>
                                    <td>Type:</td>
                                    <td>{{ $sensor->type }}</td>
                                </tr>
                                <tr>
                                    <td>Latest Value:</td>
                                    <td><a href="{{ route('sensordata.show', $sensor->latest_data->id ?? '0') }}">{{ $sensor->latest_data->value ?? 'null' }}</a></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <a class="btn btn-sm btn-primary" type="button" title="Go up to device" href="{{ route('device.show', $sensor->device_id) }}"><i class="glyphicon glyphicon-arrow-up"></i></a>
                    <span class="pull-right">
                        <a class="btn btn-sm btn-warning" type="button" title="Edit this sensor data" href="{{ route('sensor.edit', $sensor->id) }}"><i class="glyphicon glyphicon-edit"></i></a>
                            {!! Form::open(['method' => 'DELETE', 'route' => ['sensor.destroy', $sensor->id], 'style' => 'display:inline', 'onsubmit' => 'return confirm("Are you sure you want to delete this?")']) !!}
                                {!! Form::button('<i class="glyphicon glyphicon-remove"></i>', ['type' => 'submit', 'class' => 'btn btn-sm btn-danger', 'title' => 'Remove this sensor']) !!}
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
                    <h3 class="panel-title">Sensor History</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <strong>{{ $sensor->name }}</strong><br>
                            <table class="table table-device-sensors table-striped">
                                <thead>
                                    <tr>
                                        <td>ID:</td>
                                        <td>Value:</td>
                                        <td>Created At:</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sensordata as $data)
                                    <tr>
                                        <td><a href="{{ route('sensordata.show', $data->id) }}">{{ $data->id }}</td>
                                        <td>{{ $data->value }}</a></td>
                                        <td>{{ $data->created_at }} GMT</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $sensordata->links() }}
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
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