@extends('layouts.dashboard')

@section('title', 'Create User')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create User</div>
                <div class="panel-body">
                    {!! Form::open(['route' => 'user.store', 'method' => 'post', 'class' => 'form-horizontal']) !!}
                        @include('user.form')
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                {!! Form::button('<i class="glyphicon glyphicon-ok"></i> Create', array('type' => 'submit', 'class' => 'btn btn-info pull-right')) !!}
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
