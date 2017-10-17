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

//Call all functions that need to be called at the start
getStartingIDs();
updateDashboardData(true);

function updateDashboardData(keepUpdating)
{
	if (!lock)
	{
		lock = true;
		$.ajax({
			type: 'GET',
			url: '/dashboard/refresh',
			data: { device_id : currentDeviceId, location_id : currentLocationId, site_id : currentSiteId },
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
				updateActiveDeviceInfo(activeDevice['id'], activeDevice);

				//Set the rate for the image to be updated at
				setImageUpdateRate(activeDevice['image_rate']);

				//Change the stored active site and location IDs
				currentSiteId = activeSite['id'];
				currentLocationId = activeLocation['id'];
				currentDeviceId = activeDevice['id'];

				lock = false;
			},
			error: function (data)
			{
				alertBarActivate("Error in updateDashboardData()");
				console.log(data);
				lock = false;
			}
		});
	}

	if (keepUpdating)
		setTimeout("updateDashboardData(true);", dashUpdateRate)
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
			siteString += '<li class="empty site" value="' + sites[i]['id'] + '"><a>' + sites[i]['name'] + '</a></li>'
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
			locationString += '<li class="empty location" value="' + locations[i]['id'] + '"><a>' + locations[i]['name'] + '</a></li>'
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

		tableDevicesString += '<tr id="tr_' + devices[i]["id"] + '">' +
			'<td>' + devices[i]["name"] + '</td>' +
			'<td>' +
			'<div class="btn-group btn-group-sm" role="group">' +
			'<button class="btn btn-primary" type="button" onclick="changeDevice(this);" id="btn_view_' + devices[i]["id"] + '"><i class="fa fa-video-camera"></i> View</button>' +
			getCommandStatusButton(status, devices[i]["id"]) +
			'<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#graph_row_' + devices[i]["id"] + '" disabled><i class="fa fa-line-chart"></i> Graphs</button>' +
			getLockButton(status, devices[i]["id"]) +
			'<button class="btn btn-primary" type="button" data-toggle="modal" data-target="#editDeviceModal" onclick="updateDeviceModal(this);" id="btn_edit_' + devices[i]["id"] + '"><i class="glyphicon glyphicon-edit"></i> Edit</button>' +
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

function disableActiveViewBtn(device_id)
{
	$disabledViewBtn = $('#btn_view_' + device_id);
	$disabledViewBtn.prop("disabled", true);
}

//Get the starting id's for the active device, location, and site
function getStartingIDs()
{
	currentDeviceId = $('#active_device_id').val();
	currentLocationId = $('#active_location_id').val();
	currentSiteId = $('#active_site_id').val();
}

function updateActiveDeviceInfo(device_id, data)
{
	//Only update the device image if the active device has changed
	if (device_id != currentDeviceId)
	{
		//Change the photo being loaded
		deviceImageURL = deviceImageURL.substring(0, deviceImageURL.lastIndexOf('/') + 1) + device_id;

		//Update the device image url with the date to prevent the browser from caching
		updateDeviceImage();
	}

	//Change the image caption to the name of the current device
	$imageCaption.html(data['name']);

	//Change the header for the device
	$headerDevice.html(data['name']);

	//Change the temperature value
	$tempNum.text(getTemperature(data['temperature']));

	//Change the humidity value
	$humidityNum.text(getHumidity(data['humidity']));

	//Change the inside light value
	$lightInNum.text(getLight(data['light_in']));

	//Change the outside light value
	$lightOutNum.text(getLight(data['light_out']));

	//Change the cpu temp value
	$cpuTempNum.text(getCpuTemp(data['cpu_temp']));

	//Update the open and close times
	$spanOpenTime.html('<b>Open Time: </b>' + getFormattedTime(data['open_time']));
	$spanCloseTime.html('<b>Close Time: </b>' + getFormattedTime(data['close_time']));
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
	var buttonHtml = '<button class="btn btn-primary" type="button" onclick="updateDeviceCommand(this);" id="btn_lock_' + device_id + '" ';

	switch(status)
	{
		case deviceStatusEnum.open:
			buttonHtml += 'value="2"><i class="glyphicon glyphicon-resize-small"></i> Close';
			break;
		case deviceStatusEnum.opening:
			buttonHtml += 'disabled><i class=\"fa fa-cog fa-spin fa-fw\" aria-hidden=\"true\"></i> Opening';
			break;
		case deviceStatusEnum.closed:
			buttonHtml += 'value="1"><i class="glyphicon glyphicon-resize-full"></i> Open';
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
	var buttonHtml = '<button class="btn btn-primary" type="button" onclick="updateDeviceCommand(this);" id="btn_lock_' + device_id + '" value="3"';

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
