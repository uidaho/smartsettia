@extends('layouts.dashboard')

@section('title', 'Show Sensor Data')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Sensor Data</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 hidden-xs hidden-sm">
                            <strong>{{ $sensordata->sensor->name ?? 'null' }}</strong><br>
                            <table class="table table-user-information">
                                <tbody>
                                <tr>
                                    <td>ID:</td>
                                    <td>{{ $sensordata->id }}</td>
                                </tr>
                                <tr>
                                    <td>Sensor:</td>
                                    <td><a href="{{ route('sensor.show', $sensordata->sensor_id) }}">{{ $sensordata->sensor->name ?? 'null' }}</a></td>
                                </tr>
                                <tr>
                                    <td>Device:</td>
                                    <td><a href="{{ route('device.show', $sensordata->sensor->device_id ?? '0') }}">{{ $sensordata->sensor->device->name ?? 'null' }}</a></td>
                                </tr>
                                <tr>
                                    <td>Value:</td>
                                    <td>{{ $sensordata->value }}</td>
                                </tr>
                                <tr>
                                    <td>Updated At:</td>
                                    <td>{{ $sensordata->updated_at }} GMT</td>
                                </tr>
                                <tr>
                                    <td>Created At:</td>
                                    <td>{{ $sensordata->created_at }} GMT</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <a class="btn btn-sm btn-primary" type="button" title="Go up to sensor" href="{{ route('sensor.show', $sensordata->sensor_id) }}"><i class="glyphicon glyphicon-arrow-up"></i></a>
                    <span class="pull-right">
                        <a class="btn btn-sm btn-warning" type="button" title="Edit this sensor data" href="{{ route('sensordata.edit', $sensordata->id) }}"><i class="glyphicon glyphicon-edit"></i></a>
                            {!! Form::open(['method' => 'DELETE', 'route' => ['sensordata.destroy', $sensordata->id], 'style' => 'display:inline', 'onsubmit' => 'return confirm("Are you sure you want to delete this?")']) !!}
                                {!! Form::button('<i class="glyphicon glyphicon-remove"></i>', ['type' => 'submit', 'class' => 'btn btn-sm btn-danger', 'title' => 'Remove this sensor data']) !!}
                            {!! Form::close() !!}
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