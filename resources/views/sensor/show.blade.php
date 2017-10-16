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
                        <div class="col-md-12 col-lg-12 hidden-xs hidden-sm">
                            <strong>{{ $sensor->name }}</strong><br>
                            <table class="table table-sensor">
                                <tbody>
                                <tr>
                                    <td>Sensor ID:</td>
                                    <td>{{ $sensor->id }}</td>
                                </tr>
                                <tr>
                                    <td>Device ID:</td>
                                    <td>{{ $sensor->device_id }}</td>
                                </tr>
                                <tr>
                                    <td>Type:</td>
                                    <td>{{ $sensor->type }}</td>
                                </tr>
                                <tr>
                                    <td>Latest Value:</td>
                                    <td>{{ $sensor->latestData->value }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <a class="btn btn-sm btn-primary" type="button" title="E-mail this sensor data" href="mailto:{{ $sensor->email }}"><i class="glyphicon glyphicon-envelope"></i></a>
                    <span class="pull-right">
                        <a class="btn btn-sm btn-warning" type="button" title="Edit this sensor data" href="\sensor\{{ $sensor->id }}\edit"><i class="glyphicon glyphicon-edit"></i></a>
                        <a class="btn btn-sm btn-danger" type="button" title="Remove this sensor data" href="\sensor\{{ $sensor->id }}\remove"><i class="glyphicon glyphicon-remove"></i></a>
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