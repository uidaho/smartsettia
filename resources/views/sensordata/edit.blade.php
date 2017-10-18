@extends('layouts.dashboard')

@section('title', 'Edit Sensor Data#'.$sensordata->id)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Sensor Data #{{ $sensordata->id }}</div>
                <div class="panel-body">
					{!! Form::model($sensordata, array('route' => ['sensordata.update', $sensordata->id], 'method' => 'PUT', 'class' => 'form-horizontal')) !!}
						@include('sensordata.form')
						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								{!! Form::button('<i class="glyphicon glyphicon-ok"></i> Edit', array('type' => 'submit', 'class' => 'btn btn-info pull-right')) !!}
								<a href="{{ route('sensordata.show', $sensordata->id) }}" class="btn btn-primary pull-right"><i class="glyphicon glyphicon-remove"></i> Cancel</a>
							</div>
						</div>
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