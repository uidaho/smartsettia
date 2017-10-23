//Error text
let $errorDeviceName = $('#error_device_name');
let $errorSite = $('#error_site');
let $errorLocation = $('#error_location');
let $errorOpenTime = $('#error_open_time');
let $errorCloseTime = $('#error_close_time');
let $errorUpdateRate = $('#error_update_rate');
let $errorImageRate = $('#error_image_rate');
let $errorSensorRate = $('#error_sensor_rate');
//Error forms
let $formGroupDeviceName = $('#form_group_device_name');
let $formGroupSite = $('#form_group_site');
let $formGroupLocation = $('#form_group_location');
let $formGroupOpenTime = $('#form_group_open_time');
let $formGroupCloseTime = $('#form_group_close_time');
let $formGroupUpdateRate = $('#form_group_update_rate');
let $formGroupImageRate = $('#form_group_image_rate');
let $formGroupSensorRate = $('#form_group_sensor_rate');
//Modal
let $editDeviceModal = $('#editDeviceModal');
//Form inputs
let $formEditDevice = $('#form_edit_device');
let $inputDeviceName = $('#input_device_name');
let $inputOpenTime = $('#open_time');
let $inputCloseTime = $('#close_time');
let $inputUpdateRate = $('#update_rate');
let $inputImageRate = $('#image_rate');
let $inputSensorRate = $('#sensor_rate');

//Update the edit device modal with the current devices info
$controlDeviceList.on('click', '[data-edit]', function () {
	let arrayNum = $(this).attr("data-edit");
	let device_id = $(this).attr("data-device-id");
	let device = devices[arrayNum];

	//Reset Modal
	resetEditDeviceModal();

	//Update form route
	$formEditDevice.attr('action', '/device/' + device_id);

	//Update input box for the device name
	$inputDeviceName.val(device['name']);

	//Update the site dropdown
	$siteDropDown.empty();
	if (sites.length > 0)
	{
		let siteString = "";
		for (let i = 0; i < sites.length; i++)
		{
			siteString += '<option value="' + sites[i]["id"] + '">' + sites[i]["name"] + '</option>'
		}
		siteString += '<option value="">Create new site</option>';
		$siteDropDown.append(siteString);
	}

	//Update the location dropdown
	$locationDropDown.empty();
	let locationString = "";
	if (locations.length > 0)
	{
		for (let i = 0; i < locations.length; i++)
		{
			locationString += '<option value="' + locations[i]["id"] + '">' + locations[i]["name"] + '</option>'
		}
		locationString += '<option value="">Create new location</option>';
		$locationDropDown.append(locationString);
	}
	else
	{
		locationString += '<option value="">Choose a site first</option>';
		$locationDropDown.append(locationString);
	}

	//Update the open time
	$inputOpenTime.val(device['open_time']);

	//Update the close time
	$inputCloseTime.val(device['close_time']);

	//Update the update rate
	$inputUpdateRate.val(device['update_rate']);

	//Update the image rate
	$inputImageRate.val(device['image_rate']);

	//Update the sensor rate
	$inputSensorRate.val(device['sensor_rate']);

});

//Submitting the edit device modal form
$formEditDevice.on('submit', function(e)
{
	//Prevent the normal form submission
	e.preventDefault();
	let $formSubmit = $(this);

	if (!lock)
	{
		lock = true;
		$.ajax({
			url: $formSubmit.prop('action'),
			method: 'POST',
			data: $formSubmit.serialize(),
			dataType: "json",
			success: function (data) {
				lock = false;

				//Update the page
				let targetURL = '/dashboard/refresh';
				let targetData = { device_id : currentDeviceId, location_id : currentLocationId, site_id : currentSiteId };
				updateDashboardData(targetURL, targetData);

				//Close the edit device modal
				$editDeviceModal.modal('hide');

				//Display a message of success to the user
				alertBarActivate(data['success'], 'success');
			},
			error: function (data) {
				if (data.status === 404)
				{
					alertBarActivate("Device not found, try again later.", 'error');
					console.log("Invalid data");
				}
				else if (data.status === 422)
				{
					let errors = data.responseJSON['errors'];

					if ('name' in errors)
					{
						$errorDeviceName.html(errors['name'][0]);
						$formGroupDeviceName.addClass('has-error');
					}

					if ('new_site_name' in errors)
					{
						$errorSite.html(errors['new_site_name'][0]);
						$formGroupSite.addClass('has-error');
					}
					else if ('site' in errors)
					{
						$errorSite.html(errors['site'][0]);
						$formGroupSite.addClass('has-error');
					}

					if ('new_location_name' in errors)
					{
						$errorLocation.html(errors['new_location_name'][0]);
						$formGroupLocation.addClass('has-error');
					}
					else if ('location' in errors)
					{
						$errorLocation.html(errors['location'][0]);
						$formGroupLocation.addClass('has-error');
					}

					if ('open_time' in errors)
					{
						$errorOpenTime.html(errors['open_time'][0]);
						$formGroupOpenTime.addClass('has-error');
					}

					if ('close_time' in errors)
					{
						$errorCloseTime.html(errors['close_time'][0]);
						$formGroupCloseTime.addClass('has-error');
					}

					if ('update_rate' in errors)
					{
						$errorUpdateRate.html(errors['update_rate'][0]);
						$formGroupUpdateRate.addClass('has-error');
					}

					if ('image_rate' in errors)
					{
						$errorImageRate.html(errors['image_rate'][0]);
						$formGroupImageRate.addClass('has-error');
					}

					if ('sensor_rate' in errors)
					{
						$errorSensorRate.html(errors['sensor_rate'][0]);
						$formGroupSensorRate.addClass('has-error');
					}
				}
				else if (data.status === 403)
				{
					alertBarActivate("Sorry, you do not have permission to edit this device.", 'error');
					console.log("Dont have permission");

					//Close the edit device modal
					$editDeviceModal.modal('hide');
				}
				else
				{
					console.log("Uncaught error in device edit form submit", 'error');

					//Close the edit device modal
					$editDeviceModal.modal('hide');
				}

				console.log(data);

				lock = false;
			}
		});
	}
});

//Resets the basic elements on the edit device Modal
function resetEditDeviceModal()
{
	//Reset the drop-downs and text-boxes
	$siteDropDown.show();
	$siteTextBox.hide();
	$locationDropDown.show();
	$locationTextBox.hide();
	$locationTextBox.val('');
	$siteTextBox.val('');

	//Remove all the error text
	$errorDeviceName.html('');
	$errorSite.html('');
	$errorSite.html('');
	$errorLocation.html('');
	$errorLocation.html('');
	$errorOpenTime.html('');
	$errorCloseTime.html('');
	$errorUpdateRate.html('');
	$errorImageRate.html('');
	$errorSensorRate.html('');

	//Remove has-error class from all the form groups
	$formGroupDeviceName.removeClass('has-error');
	$formGroupSite.removeClass('has-error');
	$formGroupLocation.removeClass('has-error');
	$formGroupOpenTime.removeClass('has-error');
	$formGroupCloseTime.removeClass('has-error');
	$formGroupUpdateRate.removeClass('has-error');
	$formGroupImageRate.removeClass('has-error');
	$formGroupSensorRate.removeClass('has-error');
}