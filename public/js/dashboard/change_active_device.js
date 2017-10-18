$(document).ready(function() {
	//Change the selected device for the page
	$("#control_devices_list").on('click', '[data-view]', function () {
		if (!lock)
		{
			lock = true;
			var device_id = $(this).attr("data-device-id");
			var $btn = $(this);

			//Get device info
			$.ajax({
				type: 'GET',
				url: '/dashboard/change/device/' + device_id,
				data: '',
				dataType: "json",
				success: function (data) {
					updateActiveDeviceInfo(device_id, data);

					//Disable the selected view button and enable the previously disabled view button
					$btn.prop("disabled", true);
					$disabledViewBtn.prop("disabled", false);
					$disabledViewBtn = $btn;

					//Store the current device's id
					currentDeviceId = device_id;

					lock = false;
				},
				error: function (data) {
					if (data.status === 404)
					{
						alertBarActivate("Device not found, try again later.");
					}
					else
					{
						alertBarActivate("Uncaught error in changeDevice()");
					}

					lock = false;
				}

			});
		}
	});
});
