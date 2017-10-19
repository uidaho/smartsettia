@extends('layouts.dashboard')

@section('title', 'Edit Device')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Device</div>
				<div class="panel-body">
                    {!! Form::model($device, ['route' => ['device.update', $device->id], 'method' => 'put', 'class' => 'form-horizontal', 'id' => 'form_edit_device']) !!}
                        @include('device.form')
                        <div class="form-group" id="form_group_view_buttons_div">
                        	<div class="col-md-6 col-md-offset-4">
                        		{!! Form::button('<i class="glyphicon glyphicon-ok"></i> Save', array('type' => 'submit', 'class' => 'btn btn-info pull-right')) !!}
                        		<a href="{{ route('device.show', $device->id) }}" class="btn btn-primary pull-right"><i class="glyphicon glyphicon-remove"></i> Cancel</a>
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

@section('scripts')
	<script src="{{ asset('js/device_edit.js') }}"></script>
@endsection