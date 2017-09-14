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

                        <div class="form-group{{ $errors->has('site') ? ' has-error' : '' }}">
                            {!! Form::label('site', 'Site', ['class' =>'col-sm-3 control-label']) !!}
                            <div class="col-sm-9">
								@if ($site)
									<input class="form-control" name="site" placeholder="eg: Sixth Street Greenhouse" value="{{ $site->name }}" id="site">
								@else
									<input class="form-control" name="site" placeholder="eg: Sixth Street Greenhouse" id="site">
								@endif
                                <small class="text-danger">{{ $errors->first('site') }}</small>
                            </div>
                        </div>

						<div class="form-group{{ $errors->has('location') ? ' has-error' : '' }}">
							{!! Form::label('location', 'Location', ['class' => 'col-sm-3 control-label']) !!}
							<div class="col-sm-9">
								@if ($location)
									<input class="form-control" name="location" placeholder="eg: Greenhouse 1A" value="{{ $location->name }}" id="location">
								@else
									<input class="form-control" name="location" placeholder="eg: Greenhouse 1A" id="location">
								@endif
								<small class="text-danger">{{ $errors->first('location') }}</small>
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
