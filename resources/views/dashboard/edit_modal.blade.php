<!-- Modal -->
<div class="modal fade" id="editDeviceModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Edit Device</h4>
			</div>
			<div class="modal-body">
				{!! Form::model($active_data['device'], ['route' => ['device.update', $active_data['device']->id], 'method' => 'put', 'class' => 'form-horizontal', 'id' => 'form_edit_device']) !!}
					@include('device.form')
				{!! Form::close() !!}
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-info" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Cancel</button>
				<button class="btn btn-primary" type="submit" form="form_edit_device"><i class="glyphicon glyphicon-ok"></i> Save</button>
			</div>
		</div>
	</div>
</div>