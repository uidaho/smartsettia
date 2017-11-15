let $headerSite = $('#header_site');
let $headerLocation = $('#header_location');
let $headerDevice = $('#header_device');
//Spans under device name
let $spanOpenTime = $('#span_open_time');
let $spanCloseTime = $('#span_close_time');
//Lists and there button for changing the site and location
let $siteList = $('#site_change');
let $locationList = $('#location_change');
let $btnChangeSite = $('#btn_change_site');
let $btnChangeLoc = $('#btn_change_loc');
//Helper Variables
let $disabledViewBtn;
let currentDeviceId;
let currentLocationId;
let currentSiteId;
//Success and failure alert bar
let $alertSuccessBar = $('#alert_success_bar');
let $alertSuccessText = $('#success_bar_text');
let $alertFailureBar = $('#alert_failure_bar');
let $alertFailureText = $('#failure_bar_text');
//Image alert bar
let $alertImageBar = $('#alert_stale_image_bar');
let $alertImageText = $('#image_stale_bar_text');
let userExitedImageAlert = false;
//Update rates
let dashUpdateRate = 5000;
let imageUpdateRate = 30000;
let imageUpdateTimeout;
//Lock Ajax calls
let lock = false;
//Store the current sites, locations, and devices
let sites;
let locations;
let devices;
//The current device pagination offset
let currentPaginationPage = 0;
//The table that holds the devices
let $deviceTableHolder = $('#device_table_holder');
//Device with preset data used for when the selected location doesn't have any devices
let deviceDefault = {
	'id': 0, 'name': 'No Devices', 'location_id': 0, 'close_time': "17:00", 'open_time': '08:00',
	'cover_command': 'lock', 'cover_status': 'locked', 'image_rate': 3600, 'sensor_rate': 3600, 'update_rate': 3600
};
//Location with preset data used for when the selected site has no locations
let locationDefault = {
	'id': 0, 'name': 'No Locations', 'site_id': 0
};
//Site with preset data used for when there are no sites
let siteDefault = {
	'id': 0, 'name': 'No Sites'
};

//Call all functions that need to be called at the start
getStartingIDs();
refreshDashboardData();

//Continuously refresh dashboard data
function refreshDashboardData()
{
	let targetURL = '/dashboard';
	let targetData = {
		device_id: currentDeviceId,
		location_id: currentLocationId,
		site_id: currentSiteId,
		page: currentPaginationPage
	};
	updateDashboardData(targetURL, targetData);
	setTimeout("refreshDashboardData();", dashUpdateRate);
}

//Change site
$siteList.on('click', 'li[data-site-id]', function () {
	let targetURL = '/dashboard';
	let targetData = {site_id: $(this).attr("data-site-id")};
	updateDashboardData(targetURL, targetData);
});

//Change location
$locationList.on('click', 'li[data-location-id]', function () {
	let targetURL = '/dashboard';
	let targetData = {location_id: $(this).attr("data-location-id"), site_id: currentSiteId};
	updateDashboardData(targetURL, targetData);
});

//Change the device pagination page
$deviceTableHolder.on('click', '#pagination_links', function (e) {
	//Prevent the normal link redirect
	e.preventDefault();
	let $clickedElement = $(event.target);

	if (typeof $clickedElement.attr('href') !== typeof undefined && $clickedElement.attr('href') !== false)
	{
		let pageNum = $clickedElement.attr('href').split('page=')[1];
		let targetURL = '/dashboard';
		let targetData = {
			location_id: currentLocationId,
			site_id: currentSiteId,
			page: pageNum
		};
		updateDashboardData(targetURL, targetData);
	}
});

function updateDashboardData(targetURL, targetData)
{
	if (!lock)
	{
		lock = true;
		$.ajax({
			type: 'GET',
			url: targetURL,
			data: targetData,
			dataType: "json",
			success: function (data) {
				//Get the active site, location, and device
				let activeSite = data['active_data']['site'] || siteDefault;
				let activeLocation = data['active_data']['location'] || locationDefault;
				let activeDevice = data['active_data']['device'] || deviceDefault;
				//Html code of the device table
				let html_device_table = data['html_device_table'];

				//Store all the currently loaded sites, locations, and devices
				sites = data['sites'];
				locations = data['locations'];
				devices = data['devices']['data'];

				//Change the active site and location names
				$headerSite.html(activeSite['name']);
				$headerLocation.html('<b>Location: </b>' + activeLocation['name']);

				//Update the site dropdown list
				updateSiteDropdown(sites);

				//Update the location dropdown list
				updateLocationDropdown(locations);

				//Update the devices table
				$deviceTableHolder.html(html_device_table);

				//Hide the view button of the active device
				disableActiveViewBtn(activeDevice['id']);

				//Set the device image url, sensor values, and the device header name
				updateActiveDeviceInfo(activeDevice);

				//Set the rate for the image to be updated at
				setImageUpdateRate(activeDevice['image_rate']);

				//Display or hide the image stale alert depending on if the image is stale or not
				updateImageStaleAlert(activeDevice);

				//Update the stored active site, location, and device IDs
				currentSiteId = activeSite['id'];
				currentLocationId = activeLocation['id'];
				currentDeviceId = activeDevice['id'];

				//Update the current page for pagination
				if (data['devices']['current_page'] > data['devices']['last_page'])
					currentPaginationPage = data['devices']['last_page'];
				else
					currentPaginationPage = data['devices']['current_page'];

				lock = false;
			},
			error: function (data) {
				if (data.status === 404)
				{
					alertBarActivate("An error was encountered, please try again later.", 'error');
				}
				else
				{
					alertBarActivate("Uncaught error in updateDashboardData()", 'error');
				}

				console.log(data);
				lock = false;
			}
		});
	}
}

//Change the selected device for the page
$deviceTableHolder.on('click', '[data-view]', function () {
	if (!lock)
	{
		lock = true;
		let arrayNum = $(this).attr("data-view");
		let device_id = $(this).attr("data-device-id");

		//Set the device image url, sensor values, and the device header name
		updateActiveDeviceInfo(devices[arrayNum]);

		//Set the rate for the image to be updated at
		setImageUpdateRate(devices[arrayNum]['image_rate']);

		//Disable the selected view button and enable the previously disabled view button
		$(this).prop("disabled", true);
		$disabledViewBtn.prop("disabled", false);
		$disabledViewBtn = $(this);

		//Reset the user exiting the stale image alert
		userExitedImageAlert = false;
		//Alert the user if the image for the selected device is stale
		if (devices[arrayNum]['isImageStale'] && !userExitedImageAlert)
			alertImageBarActivate();
		else
			resetImageAlert();

		//Store the current device's id
		currentDeviceId = device_id;

		lock = false;
	}
});

//Update the site dropdown list
function updateSiteDropdown(sites)
{
	$siteList.empty();
	if (Object.keys(sites).length > 1)
	{
		let siteString = "";
		for (let i = 1; i < Object.keys(sites).length; i++)
		{
			siteString += '<li data-site-id="' + sites[i]['id'] + '"><a>' + sites[i]['name'] + '</a></li>'
		}
		$siteList.append(siteString);
		$btnChangeSite.show();
	}
	else
	{
		$btnChangeSite.hide();
	}
}

//Update the location dropdown list
function updateLocationDropdown(locations)
{
	$locationList.empty();

	if (Object.keys(locations).length > 1)
	{
		let locationString = "";
		for (let i = 1; i < Object.keys(locations).length; i++)
		{
			locationString += '<li data-location-id="' + locations[i]['id'] + '"><a>' + locations[i]['name'] + '</a></li>'
		}
		$locationList.append(locationString);
		$btnChangeLoc.show();
	}
	else
	{
		$btnChangeLoc.hide();
	}
}

//Disable the starting active device's view button
function disableActiveViewBtn(device_id)
{
	$disabledViewBtn = $deviceTableHolder.find("button[data-view][data-device-id=" + device_id + "]");
	$disabledViewBtn.prop("disabled", true);
}

//Get the starting id's for the active device, location, and site
function getStartingIDs()
{
	currentDeviceId = $('#active_device_id').val();
	currentLocationId = $('#active_location_id').val();
	currentSiteId = $('#active_site_id').val();
	currentPaginationPage = $('#active_device_table_page').val();
}

function updateActiveDeviceInfo(device)
{
	//Only update the device image if the active device has changed
	if (device['id'] !== currentDeviceId)
	{
		//Change the photo being loaded
		deviceImageURL = deviceImageURL.substring(0, deviceImageURL.lastIndexOf('/') + 1) + device['id'];

		//Change the image download name
		$downloadImageLink.attr('download', 'smartsettia-device-' + device['id'] + '_' + Date.now() + '.jpg');

		//Update the device image url with the date to prevent the browser from caching
		updateDeviceImage();
	}

	//Change the image caption to the name of the current device
	$imageCaption.html(device['name']);

	//Change the header for the device
	$headerDevice.html(device['name']);

	//Update the open and close times
	$spanOpenTime.html('<b>Open Time: </b>' + getFormattedTime(device['open_time']));
	$spanCloseTime.html('<b>Close Time: </b>' + getFormattedTime(device['close_time']));
}

//Format the time to be hours:mins[am or pm]
function getFormattedTime(time)
{
	let formattedTime;
	let temp = time.split(':');
	let hours = parseInt(temp[0]);
	let mins = temp[1];
	let period;

	if (hours >= 12)
		period = 'pm';
	else
		period = 'am';

	hours = ((hours + 11) % 12) + 1;
	formattedTime = hours + ':' + mins + period;

	return formattedTime;
}

//If the update rate has changed cancel the ongoing setTimeout(),
// convert the image update rate, and call the new setTimeout()
function setImageUpdateRate(time)
{
	let formattedTime;

	formattedTime = parseInt(time) * 1000;

	//If the time is less then a second then set it to 30 seconds
	if (formattedTime < 1000)
		formattedTime = 30000;

	if (imageUpdateRate !== formattedTime)
	{
		clearTimeout(imageUpdateTimeout);
		imageUpdateRate = formattedTime;
		refreshImage()
	}
	else
		imageUpdateRate = formattedTime;
}

//Display or hide the image stale alert depending on if the image is stale or not
function updateImageStaleAlert(activeDevice)
{
	//Alert the user if the image for the selected device is stale
	if (activeDevice['isImageStale'] && !userExitedImageAlert)
		alertImageBarActivate();

	//Hide alert if the image is not stale anymore
	if (!activeDevice['isImageStale'] && $alertImageBar.is(':visible'))
		resetImageAlert();
}

//Reset the user exiting the stale image alert
function resetImageAlert()
{
	$alertImageBar.trigger("click");
	userExitedImageAlert = false;
}

//Display the alert bar with the given message
function alertBarActivate(message, type)
{
	if (type === "success")
	{
		$alertSuccessText.html(message);
		$alertSuccessBar.show();
	}
	else
	{
		$alertFailureText.html('<strong>Whoops!</strong> ' + message);
		$alertFailureBar.show();
	}
}

//Hide the Success alert bar
$alertSuccessBar.on('click', function () {
	$alertSuccessBar.hide();
});

//Hide the failure alert bar
$alertFailureBar.on('click', function () {
	$alertFailureBar.hide();
});

//Display the image alert bar
function alertImageBarActivate()
{
	$alertImageText.html('<strong>Warning!</strong> This image is stale');
	$alertImageBar.show();
}

//Hide the failure alert bar
$alertImageBar.on('click', function ()
{
	$alertImageBar.hide();
	userExitedImageAlert = true;
});