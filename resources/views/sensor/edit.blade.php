@extends('layouts.dashboard')

@section('title', 'Edit Sensor')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Sensor</div>
                <div class="panel-body">
					{!! Form::open(array('route' => ['sensor.update', $sensor->id], 'method' => 'PUT')) !!}
						<ul>
							<li>
								{!! Form::label('device_id', 'Device_id:') !!}
								{!! Form::text('sensor_id') !!}
							</li>
							<li>
								{!! Form::label('name', 'Name:') !!}
								{!! Form::text('name') !!}
							</li>
							<li>
								{!! Form::label('type', 'Type:') !!}
								{!! Form::text('type') !!}
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