@extends('layouts.dashboard')

@section('title', 'Users')

{{-- @section('content')
<div class="container">
	<div class="page-header">
		<h3>User List</h3>
	</div>
	<p>A list of all the users in the system.</p>
	<div class="table-responsive">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>id</th>
					<th>name</th>
					<th>email</th>
                    <th>created_at</th>
                    <th>updated_at</th>
					<th>Controls</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($users as $user)
				<tr>
					<td>{{ $user->id }}</td>
					<td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td>{{ $user->updated_at }}</td>
					<td>
						<div class="btn-group" role="group">
							<button class="btn btn-primary" type="button" title="View Log"><i class="glyphicon glyphicon-eye-open"></i> </button>
							<button class="btn btn-primary" type="button" title="Edit Groups"><i class="glyphicon glyphicon-user"></i> </button>
							<button class="btn btn-primary btn-warning" type="button" title="Disable User"><i class="glyphicon glyphicon-lock"></i> </button>
							<button class="btn btn-primary btn-danger" type="button" title="Delete User"><i class="glyphicon glyphicon-remove"></i> </button>
						</div>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
    {{ $users->links() }}
</div>
@endsection --}}

@section('content')
{!! $dataTable->table(['class' => 'table table-bordered'], true) !!}
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
