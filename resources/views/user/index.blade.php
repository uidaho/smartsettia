@extends('layouts.dashboard')

@section('title', 'Users')

@section('content')
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
@endsection
