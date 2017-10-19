@extends('layouts.dashboard')

@section('title', 'Show Location')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Location</h3>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12 col-lg-12 hidden-xs hidden-sm">
								<strong>{{ $location->name }}</strong><br>
								<table class="table table-sensor">
									<tbody>
									<tr>
										<td>ID:</td>
										<td>{{ $location->id }}</td>
									</tr>
									<tr>
										<td>Site:</td>
										<td><a href="{{ route('site.show', $location->site_id) }}">{{ $location->site->name ?? 'null' }}</a></td>
									</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="panel-footer">
						<a class="btn btn-sm btn-primary" type="button" title="Go up to site" href="{{ route('site.show', $location->site_id) }}"><i class="glyphicon glyphicon-arrow-up"></i></a>
						<span class="pull-right">
                        <a class="btn btn-sm btn-warning" type="button" title="Edit this location data" href="{{ route('location.edit', $location->id) }}"><i class="glyphicon glyphicon-edit"></i></a>
							{!! Form::open(['method' => 'DELETE', 'route' => ['location.destroy', $location->id], 'style' => 'display:inline', 'onsubmit' => 'return confirm("Are you sure you want to delete this?")']) !!}
							{!! Form::button('<i class="glyphicon glyphicon-remove"></i>', ['type' => 'submit', 'class' => 'btn btn-sm btn-danger', 'title' => 'Remove this location']) !!}
							{!! Form::close() !!}
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