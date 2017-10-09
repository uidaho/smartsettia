<!-- Modal -->
<div class="modal fade" id="editDeviceModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Edit Device</h4>
			</div>
			<div class="modal-body">
				@include('device.edit_form')
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button class="btn btn-primary" type="submit" form="form_edit_device">Save changes</button>
			</div>
		</div>
	</div>
</div>