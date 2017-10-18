@extends('layouts.dashboard')

@section('title', 'Create Sensor Data')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create Sensor Data</div>
                <div class="panel-body">
					{!! Form::open(array('route' => 'sensordata.store', 'method' => 'POST', 'class' => 'form-horizontal')) !!}
						@include('sensordata.form')
						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								{!! Form::button('<i class="glyphicon glyphicon-ok"></i> Create', ['type' => 'submit', 'class' => 'btn btn-info pull-right']) !!}
								<a href="{{ route('sensordata.index') }}" class="btn btn-primary pull-right"><i class="glyphicon glyphicon-remove"></i> Cancel</a>
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