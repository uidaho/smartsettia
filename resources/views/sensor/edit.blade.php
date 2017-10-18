@extends('layouts.dashboard')

@section('title', 'Edit Sensor #'.$sensor->id)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Sensor #{{ $sensor->id }}</div>
                <div class="panel-body">
					{!! Form::model($sensor, array('route' => ['sensor.update', $sensor->id], 'method' => 'PUT', 'class' => 'form-horizontal')) !!}
						@include('sensor.form')
						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								{!! Form::button('<i class="glyphicon glyphicon-ok"></i> Edit', array('type' => 'submit', 'class' => 'btn btn-info pull-right')) !!}
								<a href="{{ route('sensor.show', $sensor->id) }}" class="btn btn-primary pull-right"><i class="glyphicon glyphicon-remove"></i> Cancel</a>
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