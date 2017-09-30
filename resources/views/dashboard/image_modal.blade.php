<!-- Modal -->
<div id="image_modal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<img class="modal-content" src="{{ URL('image/device') . '/' . $default_device->id }}" alt="Device Image">
		<div id="image_caption">{{ $default_device->name }}</div>
	</div>
</div>