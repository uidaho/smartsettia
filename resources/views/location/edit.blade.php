@extends('layouts.dashboard')

@section('title', 'Edit Location: '.$location->name)

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading">Edit Location: {{ $location->name }}</div>
					<div class="panel-body">
						{!! Form::model($location, array('route' => ['location.update', $location->id], 'method' => 'PUT', 'class' => 'form-horizontal')) !!}
						@include('location.form')
						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								{!! Form::button('<i class="glyphicon glyphicon-ok"></i> Save', array('type' => 'submit', 'class' => 'btn btn-info pull-right')) !!}
								<a href="{{ route('location.show', $location->id) }}" class="btn btn-primary pull-right"><i class="glyphicon glyphicon-remove"></i> Cancel</a>
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