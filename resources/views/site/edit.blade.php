@extends('layouts.dashboard')

@section('title', 'Edit Site: '.$site->name)

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading">Edit Site: {{ $site->name }}</div>
					<div class="panel-body">
						{!! Form::model($site, array('route' => ['site.update', $site->id], 'method' => 'PUT', 'class' => 'form-horizontal')) !!}
						@include('site.form')
						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								{!! Form::button('<i class="glyphicon glyphicon-ok"></i> Save', array('type' => 'submit', 'class' => 'btn btn-info pull-right')) !!}
								<a href="{{ route('site.show', $site->id) }}" class="btn btn-primary pull-right"><i class="glyphicon glyphicon-remove"></i> Cancel</a>
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