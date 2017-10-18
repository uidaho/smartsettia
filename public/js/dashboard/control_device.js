//Set ajax to send csrf token with ajax call
$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});

$(document).ready(function() {
	//Open, close, or lock the selected device
	$("#control_devices_list").on('click', '[data-command]', function() {
		if (!lock)
		{
			lock = true;
			var device_id = $(this).attr("data-device-id");

			//Get the command from the buttons data command attribute
			var commandVal = $(this).attr("data-command");

			$.ajax({
				type: 'POST',
				url: '/dashboard/' + device_id + '/command',
				data: {_method: 'put', command: commandVal},
				dataType: "json",
				success: function (data) {
					lock = false;

					//Update the page
					updateDashboardData(false);
				},
				error: function (data) {
					if (data.status === 422)
					{
						alertBarActivate("The given command was invalid.");
					}
					else if (data.status === 403)
					{
						alertBarActivate("Error device is currently in use updateDeviceCommand()");
					}
					else
						alertBarActivate("Uncaught error in updateDeviceCommand()");

					lock = false;
				}

			});
		}
	});
});