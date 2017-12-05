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
		//Store the command and the route type override
		let targetData = {
			command: $(this).attr("data-command"),
			_method: 'put'
		};

		$.ajax({
			type: 'POST',
			url: '/device/' + device_id,
			data: targetData,
			dataType: "json",
			success: function (data) {
				lock = false;

				//Update the page
				let targetURL = '/dashboard';
				let newTargetData = { device_id : currentDeviceId, location_id : currentLocationId, site_id : currentSiteId, page : currentPaginationPage };
				updateDashboardData(targetURL, newTargetData);
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
					alertBarActivate("Sorry an error was encountered, try again later.", 'error');

				lock = false;
			}

		});
	}
});

//Change default device
$deviceTableHolder.on('click', '[data-default-radio]', function (e) {
	e.preventDefault();

	if (!lock)
	{
		lock = true;

		//Get the device's id
		let deviceId = $(this).attr("data-device-id");
		//Get the user's id
		let userId = $(this).attr("data-user-id");
		//Store the device id and the route type override
		let targetData = {
			preferred_device_id: deviceId,
			_method: 'put'
		};

		$.ajax({
			type: 'POST',
			url: '/user/' + userId,
			data: targetData,
			dataType: "json",
			success: function (data) {
				lock = false;

				//Update the page
				let targetURL = '/dashboard';
				let newTargetData = { device_id : currentDeviceId, location_id : currentLocationId, site_id : currentSiteId, page : currentPaginationPage };
				updateDashboardData(targetURL, newTargetData);

				//Display a message of success to the user
				alertBarActivate(data['success'], 'success');
			},
			error: function (data) {
				alertBarActivate("Sorry an error was encountered, try again later.", 'error');
				lock = false;
			}

		});
	}
});
