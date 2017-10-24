@extends('layouts.dashboard')

@section('title', 'Create Site')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading">Create Site</div>
					<div class="panel-body">
						{!! Form::open(array('route' => 'site.store', 'method' => 'POST', 'class' => 'form-horizontal')) !!}
						@include('site.form')
						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								{!! Form::button('<i class="glyphicon glyphicon-ok"></i> Create', ['type' => 'submit', 'class' => 'btn btn-info pull-right']) !!}
								<a href="{{ route('site.index') }}" class="btn btn-primary pull-right"><i class="glyphicon glyphicon-remove"></i> Cancel</a>
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