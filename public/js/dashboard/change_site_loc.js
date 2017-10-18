//Change site
$('#site_change').on('click', 'li[data-site-id]', function()
{
	var myURL = '/dashboard/change/site/' + $(this).attr("data-site-id");
	updateDashboardSiteLoc(myURL);
});

//Change location
$('#location_change').on('click', 'li[data-location-id]', function()
{
	var myURL = '/dashboard/change/location/' + $(this).attr("data-location-id");
	updateDashboardSiteLoc(myURL);
});

function updateDashboardSiteLoc(myURL)
{
	if (!lock)
	{
		lock = true;
		$.ajax({
			type: 'GET',
			url: myURL,
			data: '',
			dataType: "json",
			success: function (data) {
				var activeDevice = data['active_device'][0];
				var activeLocation = data['active_device'][1];
				var activeSite = data['active_device'][2];

				//Change the active site and location names
				$headerSite.html(activeSite['name']);
				$headerLocation.html('<b>Location: </b>' + activeLocation['name']);

				//Update the site dropdown list
				updateSiteDropdown(data['sites']);

				//Update the location dropdown list
				updateLocationDropdown(data['locations']);

				//Update the devices table with all the devices
				updateDeviceTable(data['devices']);

				//Hide the view button of the active device
				disableActiveViewBtn(activeDevice['id']);

				//Set the device image url, sensor values, and the device header name
				updateActiveDeviceInfo(activeDevice['id'], activeDevice);

				//Change the stored active site and location IDs
				currentSiteId = activeSite['id'];
				currentLocationId = activeLocation['id'];
				currentDeviceId = activeDevice['id'];

				lock = false;
			},
			error: function (data)
			{
				if (data.status === 404)
				{
					alertBarActivate("The selected site or location was not found, try again later.");
				}
				else
				{
					alertBarActivate("Uncaught error in updateDashboardSiteLoc() site/location");
				}

				lock = false;
			}
		});
	}
}