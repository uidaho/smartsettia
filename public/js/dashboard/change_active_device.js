
//Change the selected device for the page
function changeDevice(btn)
{
	if (!lock)
	{
		lock = true;
		var device_id = btn.id.substring(btn.id.lastIndexOf('_') + 1);

		//Get device info
		$.ajax({
			type: 'GET',
			url: '/device/' + device_id + '/details',
			data: '',
			dataType: "json",
			success: function (data)
			{
				var device = data[0];
				var isImageStale = data[1];

				//Show the user an alert that the image they are viewing is stale
				if (isImageStale)
					$alertImage.show();
				else
					$alertImage.hide();
				//Reset the exited image alert flag
				userExitedImageAlert = false;

				updateActiveDeviceInfo(device_id, device);

				//Disable the selected view button and enable the previously disabled view button
				$(btn).prop("disabled", true);
				$disabledViewBtn.prop("disabled", false);
				$disabledViewBtn = $(btn);

				//Store the current device's id
				currentDeviceId = device_id;

				lock = false;
			},
			error: function (data)
			{
				if (data.status === 404)
				{
					window.alert("Device not found, try again later.");
				}
				else
				{
					console.log("Uncaught error in changeDevice()");
				}

				lock = false;
			}

		});
	}
}
