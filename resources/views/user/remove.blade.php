@extends('layouts.dashboard')

@section('title', 'Remove User')

@section('content')
<div class="container">
    </br>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Remove User</div>
                <div class="panel-body">
                    Are you sure you want to remove {{ $user->name }} ({{ $user->email }})?
                    {!! Form::open(['route' => ['user.destroy', $user->id], 'method' => 'delete', 'class' => 'form-horizontal']) !!}
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                {!! Form::button('<i class="glyphicon glyphicon-trash "></i> Delete', array('type' => 'submit', 'class' => 'btn btn-danger pull-right')) !!}
                                <a href="{{ route('user.index') }}" class="btn btn-primary pull-right"><i class="glyphicon glyphicon-remove"></i> Cancel</a>
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
