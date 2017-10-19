<div class="btn-group" role="group">
    <a href="{{ route('user.show', $id) }}" class="btn btn-xs btn-primary">
        <i class="glyphicon glyphicon-eye-open"></i> Show
    </a>
    <a href="{{ route('user.edit', $id) }}" class="btn btn-xs btn-primary">
        <i class="glyphicon glyphicon-edit"></i> Edit
    </a>
    {!! Form::open(['method' => 'DELETE', 'route' => ['user.destroy', $id], 'style' => 'display:inline', 'onsubmit' => 'return confirm("Are you sure you want to delete the user named '.$name.'?")']) !!}
        {!! Form::button('<i class="glyphicon glyphicon-remove"></i> Delete', ['type' => 'submit', 'class' => 'btn btn-xs btn-danger', 'title' => 'Delete this user']) !!}
    {!! Form::close() !!}
</div>