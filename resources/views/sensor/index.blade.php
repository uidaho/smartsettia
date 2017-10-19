@extends('layouts.dashboard')

@section('title', 'Sensor')

@section('content')
<div class="container">
	<div class="page-header">
		<h3>Sensor</h3>
	</div>
	<p>A list of all sensors.</p>
	<div class="table-responsive">
		<div class="tabs">
		    <ul class="nav nav-tabs">
		        <li class="active">
		            <a href="#sensor" role="tab" data-toggle="tab">
		                <icon class="fa fa-line-chart"></icon> Sensor
		            </a>
		        </li>
		    </ul>
		    <div class="tab-content">
		        <div class="tab-pane fade active in" id="sensor">
		            {!! $dataTable->table(['class' => 'table table-bordered table-striped table-condensed'], true) !!}
		        </div>
		    </div>
		</div>
	</div>
</div>
@stop

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/autofill/2.2.0/css/autoFill.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.0/css/buttons.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.2/css/fixedHeader.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.bootstrap.min.css">
@endpush


@push('scripts')
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/autofill/2.2.0/js/dataTables.autoFill.min.js"></script>
<script src="https://cdn.datatables.net/autofill/2.2.0/js/autoFill.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.0/js/buttons.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.0/js/buttons.colVis.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.0/js/buttons.flash.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.0/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.1.2/js/dataTables.fixedHeader.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/responsive.bootstrap.min.js"></script>
<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
{!! $dataTable->scripts() !!}
@endpush
