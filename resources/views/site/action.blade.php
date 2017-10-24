<div class="btn-group" role="group">
	<a href="{{ route('site.show', $id) }}" class="btn btn-xs btn-primary">
		<i class="glyphicon glyphicon-eye-open"></i> Show
	</a>
	<a href="{{ route('site.edit', $id) }}" class="btn btn-xs btn-primary">
		<i class="glyphicon glyphicon-edit"></i> Edit
	</a>
	{!! Form::open(['method' => 'DELETE', 'route' => ['site.destroy', $id], 'style' => 'display:inline', 'onsubmit' => 'return confirm("Are you sure you want to delete this?")']) !!}
	{!! Form::button('<i class="glyphicon glyphicon-remove"></i> Delete', ['type' => 'submit', 'class' => 'btn btn-xs btn-danger', 'title' => 'Remove this site']) !!}
	{!! Form::close() !!}
</div>