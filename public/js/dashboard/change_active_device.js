
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
			success: function (data) {
				updateActiveDeviceInfo(device_id, data);

				//Disable the selected view button and enable the previously disabled view button
				$(btn).prop("disabled", true);
				$disabledViewBtn.prop("disabled", false);
				$disabledViewBtn = $(btn);

				//Store the current device's id
				currentDeviceId = device_id;

				lock = false;
			},
			error: function (data) {
				console.log("Error in changeDevice()");
				lock = false;
			}

		});
	}
}
