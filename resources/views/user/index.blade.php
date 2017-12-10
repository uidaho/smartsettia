@extends('layouts.dashboard')

@section('title', 'Users')

@section('content')
<div class="container">
	<div class="page-header">
		<h3>User List</h3>
	</div>
	<p>A list of all the users in the system.</p>
	<div class="table-responsive">
		<div class="tabs">
		    <ul class="nav nav-tabs">
		        <li class="active">
		            <a href="#users" role="tab" data-toggle="tab">
		                <icon class="fa fa-user"></icon> Users
		            </a>
		        </li>
		        <li>
		            <a href="#trash" role="tab" data-toggle="tab">
		                <i class="fa fa-trash"></i> Trash
		            </a>
		        </li>
		    </ul>
		    <div class="tab-content">
		        <div class="tab-pane fade active in" id="users">
		            {!! $dataTable->table(['class' => 'table table-bordered table-striped table-condensed'], true) !!}
		        </div>
		        <div class="tab-pane fade" id="trash">
					<table class="table table-bordered table-condensed" id="trashTable">
						<thead>
							<tr>
								<th>Id</th>
								<th>Name</th>
								<th>Deleted At</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($trashed as $trash)
							<tr>
								<th>{{ $trash->id }}</th>
								<th>{{ $trash->name }}</th>
								<th>{{ $trash->deletedAtHuman }}</th>
								<th>
									{!! Form::open(['method' => 'PUT', 'route' => ['user.restore', $trash->id], 'style' => 'display:inline', 'onsubmit' => 'return confirm("Are you sure you want to restore this user?")']) !!}
										{!! Form::button('<i class="fa fa-undo"></i> Restore', ['type' => 'submit', 'class' => 'btn btn-xs btn-primary', 'title' => 'Restore this user']) !!}
									{!! Form::close() !!}
									{!! Form::open(['method' => 'DELETE', 'route' => ['user.destroy', $trash->id], 'style' => 'display:inline', 'onsubmit' => 'return confirm("Are you sure you want to permanantly delete this user?")']) !!}
										{!! Form::button('<i class="glyphicon glyphicon-remove"></i> Delete', ['type' => 'submit', 'class' => 'btn btn-xs btn-danger', 'title' => 'Permanantly delete this user']) !!}
									{!! Form::close() !!}
								</th>
							</tr>
							@endforeach
						</tbody>
					</table>
		        </div>
		    </div>
		</div>
	</div>
</div>
@stop

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/autofill/2.2.0/css/autoFill.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.0/css/buttons.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.2/css/fixedHeader.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.bootstrap.min.css">
@endpush


@push('scripts')
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/autofill/2.2.0/js/dataTables.autoFill.min.js"></script>
<script src="https://cdn.datatables.net/autofill/2.2.0/js/autoFill.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.0/js/buttons.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.0/js/buttons.colVis.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.0/js/buttons.flash.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.0/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.1.2/js/dataTables.fixedHeader.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/responsive.bootstrap.min.js"></script>
<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
{!! $dataTable->scripts() !!}
@endpush
