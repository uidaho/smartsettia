@extends('layouts.dashboard')

@section('title', 'Edit Sensor Data')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Sensor Data</div>
                <div class="panel-body">
					{!! Form::open(array('route' => ['sensordata.update', $sensordata->id], 'method' => 'PUT')) !!}
						<ul>
							<li>
								{!! Form::label('sensor_id', 'Sensor_id:') !!}
								{!! Form::text('sensor_id') !!}
							</li>
							<li>
								{!! Form::label('value', 'Value:') !!}
								{!! Form::text('value') !!}
							</li>
							<li>
								{!! Form::submit() !!}
							</li>
						</ul>
					{!! Form::close() !!}
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