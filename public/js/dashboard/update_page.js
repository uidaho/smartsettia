var $headerSite = $('#header_site');
var $headerLocation = $('#header_location');
var $headerDevice = $('#header_device');
var $tableBody = $('#device_table tbody');
//Spans under device name
var $tempNum = $('#temperature');
var $humidityNum = $('#humidity');
var $lightInNum = $('#light_in');
var $lightOutNum = $('#light_out');
var $cpuTempNum = $('#cpu_temp');
//
var $siteList = $('#site_change');
var $locationList = $('#location_change');
var $btnChangeSite = $('#btn_change_site');
var $btnChangeLoc = $('#btn_change_loc');
var $spanOpenTime = $('#span_open_time');
var $spanCloseTime = $('#span_close_time');
//Helper Variables
var $disabledViewBtn;
var currentDeviceId;
var currentLocationId;
var currentSiteId;
//Error/Alert Bar
var $alertBar = $('#alert_bar');
//Device status enum
var deviceStatusEnum = {
	open: 1,
	opening: 2,
	closed: 3,
	closing: 4,
	locked: 5,
	error: 6
};
//Update rates
var dashUpdateRate = 5000;
var imageUpdateRate = 30000;
var imageUpdateTimeout;
//Lock Ajax calls
var lock = false;
//Store the current locations devices
var devices;

//Call all functions that need to be called at the start
getStartingIDs();
refreshDashboardData();

//Continuously refresh dashboard data
function refreshDashboardData()
{
	var targetURL = '/dashboard/refresh';
	var data = { device_id : currentDeviceId, location_id : currentLocationId, site_id : currentSiteId };
	updateDashboardData(targetURL, data);
	setTimeout("refreshDashboardData();", dashUpdateRate);
}

$(document).ready(function() {
	//Change site
	$('#site_change').on('click', 'li[data-site-id]', function () {
		var targetURL = '/dashboard/change/site/' + $(this).attr("data-site-id");
		updateDashboardData(targetURL);
	});

	//Change location
	$('#location_change').on('click', 'li[data-location-id]', function () {
		var targetURL = '/dashboard/change/location/' + $(this).attr("data-location-id");
		updateDashboardData(targetURL);
	});

	//Change the selected device for the page
	$("#control_devices_list").on('click', '[data-view]', function () {
		var arrayNum = $(this).attr("data-view");
		var device_id = $(this).attr("data-device-id");

		//Set the device image url, sensor values, and the device header name
		updateActiveDeviceInfo(devices[arrayNum]);

		//Set the rate for the image to be updated at
		setImageUpdateRate(devices[arrayNum]['image_rate']);

		//Disable the selected view button and enable the previously disabled view button
		$(this).prop("disabled", true);
		$disabledViewBtn.prop("disabled", false);
		$disabledViewBtn = $(this);

		//Store the current device's id
		currentDeviceId = device_id;
	});
});

function updateDashboardData(targetURL, data)
{
	if (!lock)
	{
		lock = true;
		$.ajax({
			type: 'GET',
			url: targetURL,
			data: data,
			dataType: "json",
			success: function (data)
			{
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
				updateActiveDeviceInfo(activeDevice);

				//Set the rate for the image to be updated at
				setImageUpdateRate(activeDevice['image_rate']);

				//Change the stored active site and location IDs
				currentSiteId = activeSite['id'];
				currentLocationId = activeLocation['id'];
				currentDeviceId = activeDevice['id'];

				devices = data['devices'];

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
					alertBarActivate("Uncaught error in updateDashboardData()");
				}
				
				console.log(data);
				lock = false;
			}
		});
	}
}

//Update the site dropdown list
function updateSiteDropdown(sites)
{
	$siteList.empty();
	if (Object.keys(sites).length > 0)
	{
		var siteString = "";
		for (i = 0; i < Object.keys(sites).length; i++)
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

	if (Object.keys(locations).length > 0)
	{
		var locationString = "";
		for (i = 0; i < Object.keys(locations).length; i++)
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

//Update the devices table
function updateDeviceTable(devices)
{
	//Empty the device table's body
	$tableBody.empty();
	var tableDevicesString = "";
	//Add the devices to the table
	for (i = 0; i < Object.keys(devices).length; i++)
	{
		//Get the devices status open, closed, locked, etc.
		var status = getDeviceStatus(devices[i]);

		tableDevicesString += '<tr>' +
			'<td>' + devices[i]["name"] + '</td>' +
			'<td>' +
			'<div class="btn-group btn-group-sm" role="group">' +
			'<button class="btn btn-primary" type="button" data-view="' + i + '" data-device-id="' + devices[i]["id"] + '"><i class="fa fa-video-camera"></i> View</button>' +
			getCommandStatusButton(status, devices[i]["id"]) +
			'<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#graph_row_' + devices[i]["id"] + '" disabled><i class="fa fa-line-chart"></i> Graphs</button>' +
			getLockButton(status, devices[i]["id"]) +
			'<button class="btn btn-primary" type="button" data-toggle="modal" data-target="#editDeviceModal" onclick="updateDeviceModal(this);" id="btn_edit_' + devices[i]["id"] + '"><i class="glyphicon glyphicon-edit"></i> Edit</button>' +
			'<button type="button" class="btn btn-default" data-command="3" data-device-id="' + devices[i]["id"] + '">Reset Command</button>' +
			'</div>' +
			'</td>' +
			'</tr>' +
			'<tr class="collapse" id="graph_row_' + devices[i]['id'] + '">' +
			'<td colspan="2">' +
			'<div>' +
			'<ul class="nav nav-tabs">' +
			'<li class="active"><a href="#tab_1_' + devices[i]["id"] + '" role="tab" data-toggle="tab"><i class="fa fa-thermometer-empty"></i> Temp <span class="badge">' + getTemperature(devices[i]['temperature']) + '</span></a></li>' +
			'<li><a href="#tab_2_' + devices[i]["id"] + '" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-tint"></i> RH <span class="badge">' + getHumidity(devices[i]['humidity']) + '</span></a></li>' +
			'<li><a href="#tab_3_' + devices[i]["id"] + '" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-adjust"></i> Light <span class="badge">' + getHumidity(devices[i]['light_in']) + '</span></a></li>' +
			'</ul>' +
			'<div class="tab-content">' +
			'<div class="tab-pane active" role="tabpanel" id="tab_1_' + devices[i]["id"] + '">' +
			'<p><img class="img-responsive" src="/img/temp-graph.png"></p>' +
			'</div>' +
			'<div class="tab-pane" role="tabpanel" id="tab_2_' + devices[i]["id"] + '">' +
			'<p><img class="img-responsive" src="/img/humidity-graph.png"></p>' +
			'</div>' +
			'<div class="tab-pane" role="tabpanel" id="tab_3_' + devices[i]["id"] + '">' +
			'<p><img class="img-responsive" src="/img/light-graph.png"></p>' +
			'</div>' +
			'</div>' +
			'</div>' +
			'</td>' +
			'</tr>'
	}
	$tableBody.append(tableDevicesString);
}

//Disable the starting active device's view button
function disableActiveViewBtn(device_id)
{
	$disabledViewBtn = $("#control_devices_list").find("button[data-view][data-device-id=" + device_id + "]");
	$disabledViewBtn.prop("disabled", true);
}

//Get the starting id's for the active device, location, and site
function getStartingIDs()
{
	currentDeviceId = $('#active_device_id').val();
	currentLocationId = $('#active_location_id').val();
	currentSiteId = $('#active_site_id').val();
}

function updateActiveDeviceInfo(device)
{
	//Only update the device image if the active device has changed
	if (device['id'] != currentDeviceId)
	{
		//Change the photo being loaded
		deviceImageURL = deviceImageURL.substring(0, deviceImageURL.lastIndexOf('/') + 1) + device['id'];

		//Update the device image url with the date to prevent the browser from caching
		updateDeviceImage();
	}

	//Change the image caption to the name of the current device
	$imageCaption.html(device['name']);

	//Change the header for the device
	$headerDevice.html(device['name']);

	//Change the temperature value
	$tempNum.text(getTemperature(device['temperature']));

	//Change the humidity value
	$humidityNum.text(getHumidity(device['humidity']));

	//Change the inside light value
	$lightInNum.text(getLight(device['light_in']));

	//Change the outside light value
	$lightOutNum.text(getLight(device['light_out']));

	//Change the cpu temp value
	$cpuTempNum.text(getCpuTemp(device['cpu_temp']));

	//Update the open and close times
	$spanOpenTime.html('<b>Open Time: </b>' + getFormattedTime(device['open_time']));
	$spanCloseTime.html('<b>Close Time: </b>' + getFormattedTime(device['close_time']));
}

//Get the temperature amount as a formatted string
function getTemperature(val)
{
	var temperature;

	if (val === null)
		temperature = "C";
	else
		temperature = val + "C";

	return temperature;
}

//Get the humidity amount as a formatted string
function getHumidity(val)
{
	var humidity;

	if (val === null)
		humidity = "%";
	else
		humidity = val + "%";

	return humidity;
}

//Get the light amount as a formatted string
function getLight(val)
{
	var light;

	if (val === null)
		light = "%";
	else
		light = val + "%";

	return light;
}

//Get the CPU temperature as a formatted string
function getCpuTemp(val)
{
	var temperature;

	if (val === null)
		temperature = "C";
	else
		temperature = val + "C";

	return temperature;
}

function getDeviceStatus(device)
{
	//console.log(device['name'] + " command: " + device["cover_command"] + " status: " + device['cover_status']);
	var status;
	var isOpen = (device['cover_command'] === 'open') && (device['cover_status'] === 'open');
	var isClosed = (device['cover_command'] === 'close') && (device['cover_status'] === 'closed');
	//console.log("isOpen: " + isOpen + " isClosed: " + isClosed);

	switch(device['cover_command'])
	{
		case 'open':
			if (isOpen)
				status = deviceStatusEnum.open;
			else
				status = deviceStatusEnum.opening;
			break;
		case 'close':
			if (isClosed)
				status = deviceStatusEnum.closed;
			else
				status = deviceStatusEnum.closing;
			break;
		case 'lock':
			status = deviceStatusEnum.locked;
			break;
		default:
			status = deviceStatusEnum.error;
	}

	if (device['cover_status'] === 'error')
		status = deviceStatusEnum.error;

	return status;
}

//Get the devices command status button as html
function getCommandStatusButton(status, device_id)
{
	var buttonHtml = '<button class="btn btn-primary" type="button" data-device-id="' + device_id + '" ';

	switch(status)
	{
		case deviceStatusEnum.open:
			buttonHtml += 'data-command="2"><i class="glyphicon glyphicon-resize-small"></i> Close';
			break;
		case deviceStatusEnum.opening:
			buttonHtml += 'disabled><i class=\"fa fa-cog fa-spin fa-fw\" aria-hidden=\"true\"></i> Opening';
			break;
		case deviceStatusEnum.closed:
			buttonHtml += 'data-command="1"><i class="glyphicon glyphicon-resize-full"></i> Open';
			break;
		case deviceStatusEnum.closing:
			buttonHtml += 'disabled><i class=\"fa fa-cog fa-spin fa-fw\" aria-hidden=\"true\"></i> Closing';
			break;
		case deviceStatusEnum.locked:
			buttonHtml += 'disabled><i class="fa fa-lock" aria-hidden="true"></i> Locked';
			break;
		default:
			buttonHtml += 'disabled><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error';
	}

	buttonHtml += '</button>';

	return buttonHtml;
}

//Get the devices lock button as html
function getLockButton(status, device_id)
{
	var buttonHtml = '<button class="btn btn-primary" type="button" data-device-id="' + device_id + '" data-command="3"';

	if (status === deviceStatusEnum.locked)
		buttonHtml += '><i class="fa fa-unlock" aria-hidden="true"></i></i> Unlock';
	else if (status === deviceStatusEnum.open || status === deviceStatusEnum.closed)
		buttonHtml += '><i class="fa fa-lock" aria-hidden="true"></i> Lock';
	else
		buttonHtml += 'disabled><i class="fa fa-lock" aria-hidden="true"></i> Lock';

	buttonHtml += '</button>';

	return buttonHtml;
}

//Format the time to be hours:mins[am or pm]
function getFormattedTime(time)
{
	var formattedTime;
	var temp = time.split(':');
	var hours = parseInt(temp[0]);
	var mins = temp[1];
	var period;

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
	var formattedTime;

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

//Display the alert bar with the given message
function alertBarActivate(message)
{
	$alertBar.html('<button type="button" class="close" aria-label="Close" onclick="$alertBar.hide()"><span aria-hidden="true">&times;</span></button>' +
		'<strong>Alert!</strong> ' + message);
	$alertBar.show();
}
