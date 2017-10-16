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
                            <strong>{{ $sensordata->sensor->name }}</strong><br>
                            <table class="table table-user-information">
                                <tbody>
                                <tr>
                                    <td>ID:</td>
                                    <td>{{ $sensordata->id }}</td>
                                </tr>
                                <tr>
                                    <td>Sensor ID:</td>
                                    <td>{{ $sensordata->sensor_id }}</td>
                                </tr>
                                <tr>
                                    <td>Value:</td>
                                    <td>{{ $sensordata->value }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <a class="btn btn-sm btn-primary" type="button" title="E-mail this sensor data" href="mailto:{{ $sensordata->email }}"><i class="glyphicon glyphicon-envelope"></i></a>
                    <span class="pull-right">
                        <a class="btn btn-sm btn-warning" type="button" title="Edit this sensor data" href="\user\{{ $sensordata->id }}\edit"><i class="glyphicon glyphicon-edit"></i></a>
                        <a class="btn btn-sm btn-danger" type="button" title="Remove this sensor data" href="\user\{{ $sensordata->id }}\remove"><i class="glyphicon glyphicon-remove"></i></a>
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