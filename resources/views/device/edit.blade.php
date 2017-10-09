@extends('layouts.dashboard')

@section('title', 'Edit Device')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Device</div>
				<div class="panel-body">
					@include('device.edit_form')
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