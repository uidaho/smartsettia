@extends('layouts.dashboard')

@section('title', 'Show Site')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Site</h3>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12 col-lg-12">
								<strong>{{ $site->name }}</strong><br>
								<table class="table table-sensor">
									<tbody>
									<tr>
										<td>ID:</td>
										<td>{{ $site->id }}</td>
									</tr>
									<tr>
										<td>Created At:</td>
										<td>{{ $site->createdAtHuman }}</td>
									</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="panel-footer clearfix">
						@can('index', App\Site::class)
							<a class="btn btn-sm btn-primary" type="button" title="Go to site list" href="{{ route('site.index') }}"><i class="glyphicon glyphicon-arrow-up"></i></a>
						@endcan
						<span class="pull-right">
							@can('edit', App\Site::class)
                        		<a class="btn btn-sm btn-warning" type="button" title="Edit this site data" href="{{ route('site.edit', $site->id) }}"><i class="glyphicon glyphicon-edit"></i></a>
							@endcan
							@can('destroy', App\Site::class)
								{!! Form::open(['method' => 'DELETE', 'route' => ['site.destroy', $site->id], 'style' => 'display:inline', 'onsubmit' => 'return confirm("Are you sure you want to delete this?")']) !!}
									{!! Form::button('<i class="glyphicon glyphicon-remove"></i>', ['type' => 'submit', 'class' => 'btn btn-sm btn-danger', 'title' => 'Remove this site']) !!}
								{!! Form::close() !!}
							@endcan
                    	</span>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Site locations</h3>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12 col-lg-12">
								<strong>{{ $site->name }}</strong><br>
								<table class="table table-device-sensors">
									<thead>
									<tr>
										<td>Name:</td>
										<td>Updated At:</td>
									</tr>
									</thead>
									<tbody>
									@foreach ($locations as $location)
										<tr>
											<td><a href="{{ route('location.show', $location->id) }}">{{ $location->name }}</a></td>
											<td>{{ is_object($location->updated_at) ? $location->updatedAtHuman : 'never' }}</td>
										</tr>
									@endforeach
									</tbody>
								</table>
								{{ $locations->links() }}
							</div>
						</div>
					</div>
					<div class="panel-footer">
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