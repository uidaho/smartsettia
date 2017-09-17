@extends('layouts.dashboard')

@section('title', 'Edit Device')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Device</div>
                <div class="panel-body">
                    {!! Form::model($device, ['route' => ['device.update', $device->id], 'method' => 'put', 'class' => 'form-horizontal']) !!}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            {!! Form::label('name', 'Name', ['class' => 'col-sm-3 control-label']) !!}
                            <div class="col-sm-9">
                                {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                <small class="text-danger">{{ $errors->first('name') }}</small>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('site') ? ' has-error' : '' }} {{ $errors->has('new_site_name') ? ' has-error' : '' }}">
                            {!! Form::label('site', 'Site', ['class' =>'col-sm-3 control-label']) !!}
                            <div class="col-sm-9">
								@if ($sites)
									<select class="form-control" name="site" id="site">
										@if (!$locations)
											<option value="-1">Choose a site</option>
										@endif
										@foreach($sites as $site)
											<option value="{{ $site->id }}">{{ $site->name }}</option>
										@endforeach
											<option value="">Create new site</option>
									</select>
								@endif
								<input class="form-control" style="display: none" name="new_site_name" placeholder="eg: Sixth Street Greenhouse" id="new_site_name">
                                <small class="text-danger">{{ $errors->first('site') }}</small>
									<small class="text-danger">{{ $errors->first('new_site_name') }}</small>
                            </div>
                        </div>

						<div class="form-group{{ $errors->has('location') ? ' has-error' : '' }} {{ $errors->has('new_location_name') ? ' has-error' : '' }}">
							{!! Form::label('location', 'Location', ['class' => 'col-sm-3 control-label']) !!}
							<div class="col-sm-9">
								<select class="form-control" name="location" id="location">
									@if ($locations)
										@foreach($locations as $location)
											<option value="{{ $location->id }}">{{ $location->name }}</option>
										@endforeach
											<option value="">Create new location</option>
									@else
										<option value="">Choose a site first</option>
									@endif
								</select>
								<input class="form-control" style="display: none" name="new_location_name" placeholder="eg: Green House 1A" id="new_location_name">
								<small class="text-danger">{{ $errors->first('location') }}</small>
									<small class="text-danger">{{ $errors->first('new_location_name') }}</small>
							</div>
						</div>


						<div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                {!! Form::button('<i class="glyphicon glyphicon-ok"></i> Save', array('type' => 'submit', 'class' => 'btn btn-info pull-right')) !!}
                                <a href="{{ route('device.index') }}" class="btn btn-primary pull-right"><i class="glyphicon glyphicon-remove"></i> Cancel</a>
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