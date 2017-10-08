//Set ajax to send csrf token with ajax call
$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});

//Open, close, or lock the selected device
function updateDeviceCommand(btn)
{
	if (!lock)
	{
		lock = true;
		var device_id = btn.id.substring(btn.id.lastIndexOf('_') + 1);

		//Get the command from the buttons value attribute
		var commandVal = btn.value;

		$.ajax({
			type: 'POST',
			url: '/dashboard/' + device_id + '/command',
			data: {_method: 'put', command: commandVal},
			dataType: "json",
			success: function (data)
			{
				lock = false;

				//Update the page
				updateDashboardData(false);
			},
			error: function (data)
			{
				if (data.status === 422)
				{
					console.log("Validation of command failed in updateDeviceCommand()");
				}
				else if (data.status === 403)
					console.log("Error device is currently in use updateDeviceCommand()");
				else
					console.log("Unknown error in updateDeviceCommand()");

				lock = false;
			}

		});
	}
}

//Open, close, or lock the selected device
function lockDevice(btn)
{
	if (!lock)
	{
		lock = true;
		var device_id = 3;

		$.ajax({
			type: 'POST',
			url: '/dashboard/' + device_id + '/disable',
			data: {_method: 'put'},
			dataType: "json",
			success: function (data)
			{
				console.log("It worked");
				lock = false;

				//Update the page
				//updateDashboardData(false);
			},
			error: function (data)
			{
				console.log("Unknown error in lockDevice()");
				lock = false;
			}

		});
	}
}