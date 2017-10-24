<div class="btn-group" role="group">
	<a href="{{ route('location.show', $id) }}" class="btn btn-xs btn-primary">
		<i class="glyphicon glyphicon-eye-open"></i> Show
	</a>
	<a href="{{ route('location.edit', $id) }}" class="btn btn-xs btn-primary">
		<i class="glyphicon glyphicon-edit"></i> Edit
	</a>
	{!! Form::open(['method' => 'DELETE', 'route' => ['location.destroy', $id], 'style' => 'display:inline', 'onsubmit' => 'return confirm("Are you sure you want to delete this?")']) !!}
	{!! Form::button('<i class="glyphicon glyphicon-remove"></i> Delete', ['type' => 'submit', 'class' => 'btn btn-xs btn-danger', 'title' => 'Remove this location']) !!}
	{!! Form::close() !!}
</div>