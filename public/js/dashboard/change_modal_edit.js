//Error text
var $errorDeviceName = $('#error_device_name');
var $errorSite = $('#error_site');
var $errorLocation = $('#error_location');
var $errorOpenTime = $('#error_open_time');
var $errorCloseTime = $('#error_close_time');
var $errorUpdateRate = $('#error_update_rate');
var $errorImageRate = $('#error_image_rate');
var $errorSensorRate = $('#error_sensor_rate');
//Error forms
var $formGroupDeviceName = $('#form_group_device_name');
var $formGroupSite = $('#form_group_site');
var $formGroupLocation = $('#form_group_location');
var $formGroupOpenTime = $('#form_group_open_time');
var $formGroupCloseTime = $('#form_group_close_time');
var $formGroupUpdateRate = $('#form_group_update_rate');
var $formGroupImageRate = $('#form_group_image_rate');
var $formGroupSensorRate = $('#form_group_sensor_rate');
//Modal
var $editDeviceModal = $('#editDeviceModal');
//Form inputs
var $formEditDevice = $('#form_edit_device');
var $inputDeviceName = $('#input_device_name');
var $inputOpenTime = $('#open_time');
var $inputCloseTime = $('#close_time');
var $inputUpdateRate = $('#update_rate');
var $inputImageRate = $('#image_rate');
var $inputSensorRate = $('#sensor_rate');

//Remove the form buttons that are not used in modal
$('#form_group_view_buttons_div').remove();

//Update the edit device modal with the current devices info
function updateDeviceModal(btn)
{
	var editDeviceID = btn.id.substring(btn.id.lastIndexOf('_') + 1);

	//Reset Modal
	resetEditDeviceModal();

	//Update form route
	$formEditDevice.attr('action', '/device/' + editDeviceID);

	if (!lock)
	{
		lock = true;
		$.ajax({
			type: 'GET',
			url: '/device/' + editDeviceID + '/edit',
			data: '',
			dataType: "json",
			success: function (data) {
				//Update input box for the device name
				$inputDeviceName.val(data['device']['name']);

				//Update the site dropdown
				$siteDropDown.empty();
				if (Object.keys(data['sites']).length > 0)
				{
					var siteString = "";
					for (i = 0; i < Object.keys(data['sites']).length; i++)
					{
						siteString += '<option value="' + data["sites"][i]["id"] + '">' + data["sites"][i]["name"] + '</option>'
					}
					siteString += '<option value="">Create new site</option>';
					$siteDropDown.append(siteString);
				}

				//Update the location dropdown
				$locationDropDown.empty();
				var locationString = "";
				if (Object.keys(data['locations']).length > 0)
				{
					for (i = 0; i < Object.keys(data['locations']).length; i++)
					{
						locationString += '<option value="' + data["locations"][i]["id"] + '">' + data["locations"][i]["name"] + '</option>'
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
				$inputOpenTime.val(data['device']['open_time']);

				//Update the close time
				$inputCloseTime.val(data['device']['close_time']);

				//Update the update rate
				$inputUpdateRate.val(data['device']['update_rate']);

				//Update the image rate
				$inputImageRate.val(data['device']['image_rate']);

				//Update the sensor rate
				$inputSensorRate.val(data['device']['sensor_rate']);

				lock = false;
			},
			error: function (data)
			{
				console.log("Error in updateDeviceModal() " + data);
				//Close the edit device modal
				$editDeviceModal.modal('hide');
				lock = false;
			}
		});
	}
	else
	{
		//Close the edit device modal
		$editDeviceModal.modal('hide');
	}
}

//Submitting the edit device modal form
$formEditDevice.on('submit', function(e)
{
	//Prevent the normal form submission
	e.preventDefault();
	var $this = $(this);

	if (!lock)
	{
		lock = true;
		$.ajax({
			url: $this.prop('action'),
			method: 'POST',
			data: $this.serialize(),
			dataType: "json",
			success: function (data) {
				lock = false;
				//Update the page
				updateDashboardData(false);

				//Close the edit device modal
				$editDeviceModal.modal('hide');
			},
			error: function (data) {
				if (data.status === 404)
				{
					alertBarActivate("Device not found, try again later.");
				}
				else if (data.status === 422)
				{
					var errors = data.responseJSON['errors'];

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
					alertBarActivate("Sorry, you do not have permission to edit this device.");

					//Close the edit device modal
					$editDeviceModal.modal('hide');
				}
				else
				{
					alertBarActivate("Uncaught error in device edit form submit");
					//Close the edit device modal
					$editDeviceModal.modal('hide');
				}

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