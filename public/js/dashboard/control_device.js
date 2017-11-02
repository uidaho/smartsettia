//Set ajax to send csrf token with ajax call
$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});

//Open, close, or lock the selected device
$deviceTableHolder.on('click', '[data-command]', function () {
	if (!lock)
	{
		lock = true;

		//Get the device's id
		let device_id = $(this).attr("data-device-id");
		//Get the devices position in the devices array
		let devicePos = $(this).attr("data-array-pos");
		//Get the devices data
		let targetData = devices[devicePos];
		//Update the cover command with the command from the buttons data command attribute
		targetData['command'] = $(this).attr("data-command");
		//Update the location id to the current location id
		targetData['location_id'] = currentLocationId;
		//Add current site id
		targetData['site_id'] = currentSiteId;
		//Add the route type override
		targetData['_method'] = 'put';

		$.ajax({
			type: 'POST',
			url: '/device/' + device_id,
			data: targetData,
			dataType: "json",
			success: function (data) {
				lock = false;

				//Update the page
				let targetURL = '/dashboard';
				let targetData = { device_id : currentDeviceId, location_id : currentLocationId, site_id : currentSiteId, page : currentPaginationPage };
				updateDashboardData(targetURL, targetData);
			},
			error: function (data) {
				if (data.status === 422)
				{
					alertBarActivate("The given command was invalid.", 'error');
				}
				else if (data.status === 403)
				{
					alertBarActivate("That device is currently in use.", 'error');
				}
				else
					alertBarActivate("Uncaught error in updateDeviceCommand()", 'error');

				console.log(data);

				lock = false;
			}

		});
	}
});
