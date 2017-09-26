var $headerSite = $('#header_site');
var $headerLocation = $('#header_location');
var $headerDevice = $('#header_device');
var $tableBody = $('#device_table tbody');
var $tempNum = $('#temperature');
var $humidityNum = $('#humidity');
var $lightNum = $('#light');
var $currentSiteId = $("#current_site_id");
var $currentLocationId = $("#current_location_id");
var $siteList = $('#site_change');
var $locationList = $('#location_change');
var $btnChangeSite = $('#btn_change_site');
var $btnChangeLoc = $('#btn_change_loc');
var $formEditDevice = $('#form_edit_device');
var $inputDeviceName = $('#input_device_name');
var $inputOpenTime = $('#open_time');
var $inputCloseTime = $('#close_time');
var $spanOpenTime = $('#span_open_time');
var $spanCloseTime = $('#span_close_time');
var hiddenViewBtn;
var currentDeviceId;

//Change Location
$('#location_change, #site_change').on('click', '.empty', function()
{
	var location_id, site_id, myURL;
	if ($(this).hasClass('location'))
	{
		//Used for changing locations
		location_id = $(this).val();
		site_id = $currentSiteId.val();
		myURL = '/dashboard/locationUpdate/' + location_id + '/' + site_id;
	}
	else
	{
		//Used for changing sites
		site_id = $(this).val();
		myURL = '/dashboard/siteUpdate/' + site_id;
	}

	updateDashboardData(myURL);
});

function updateDashboardData(myURL)
{
	$.ajax({
		type: 'GET',
		url: myURL,
		data: '',
		success: function(data)
		{
			//Change the site and location names
			$headerSite.html(data['default_device']['site_name']);
			$headerLocation.html('<b>Location: </b>' + data['default_device']['location_name']);

			//Change the site and location IDs stored in the hidden buttons
			$currentSiteId.val(data['default_device']['site_id']);
			$currentLocationId.val(data['default_device']['location_id']);

			//Update the site dropdown list
			updateSiteDropdown(data['sites']);

			//Update the location dropdown list
			updateLocationDropdown(data['locations']);

			//Update the devices table with all the devices
			updateDeviceTable(data['devices']);

			//Hide the view button of the active device
			hideFirstViewBtn();

			//Set the device image url, sensor values, and the device header name
			updateActiveDeviceInfo(data['default_device']['id'], data['default_device']);
		},
		error: function(data)
		{
			location.reload();
		}
	});
}

function hideFirstViewBtn()
{
	var tr_id = $('#device_table tr').eq(1).attr('id');
	var device_id = tr_id.substring(tr_id.indexOf('_') + 1);
	currentDeviceId = device_id;
	hiddenViewBtn = $('#btn_view_' + device_id);
	hiddenViewBtn.css('visibility','hidden');
}
hideFirstViewBtn();

//Change the selected device for the page
function changeDevice(btn)
{
	var device_id = btn.id.substring(btn.id.lastIndexOf('_') + 1);

	//Store the current device's id
	currentDeviceId = device_id;

	//Get device info
	$.ajax({
		type: 'GET',
		url: '/device/' + device_id + '/details',
		data: '',
		success: function(data)
		{
			updateActiveDeviceInfo(device_id, data);

			//Hide the view button
			$(btn).css('visibility','hidden');
			hiddenViewBtn.css('visibility','visible');
			hiddenViewBtn = $(btn);
		}
	});
}

function updateActiveDeviceInfo(device_id, data)
{
	//Change the photo being loaded
	deviceImageURL = deviceImageURL.substring(0, deviceImageURL.lastIndexOf('/') + 1) + device_id;

	//Change the header for the device
	$headerDevice.html(data['name']);

	//Change the temperature value
	$tempNum.text(getTemperature(data['temperature']));

	//Change the humidity value
	$humidityNum.text(getHumidity(data['humidity']));

	//Change the light value
	$lightNum.text(getLight(data['light_in']));

	//Update the open and close times
	$spanOpenTime.html('<b>Open Time: </b>' + data['open_time']);
	$spanCloseTime.html('<b>Close Time: </b>' + data['close_time']);
}

//Edit Device
function updateDeviceModal(btn)
{
	var editDeviceID = btn.id.substring(btn.id.lastIndexOf('_') + 1);

	//Reset Modal
	resetEditDeviceModal();

	//Update form route
	$formEditDevice.attr('action', 'https://smartsettia.com/device/' + editDeviceID);

	$.ajax({
		type: 'GET',
		url: '/device/' + editDeviceID + '/edit/details',
		data: '',
		success: function(data)
		{
			//Update input box for the device name
			$inputDeviceName.val(data['device']['name']);

			//Update the site dropdown
			$siteDropDown.empty();
			if (data['sites'].length > 0)
			{
				var siteString = "";
				for (i = 0; i < data['sites'].length; i++)
				{
					siteString += '<option value="' + data["sites"][i]["id"] + '">' + data["sites"][i]["name"] + '</option>'
				}
				siteString += '<option value="">Create new site</option>';
				$siteDropDown.append(siteString);
			}

			//Update the location dropdown
			$locationDropDown.empty();
			var locationString = "";
			if (data['locations'].length > 0)
			{
				for (i = 0; i < data['locations'].length; i++)
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
		}
	});
}

//Resets the basic elements on the edit device Modal
function resetEditDeviceModal()
{
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

	//Remove has-error class from all the form groups
	$formGroupDeviceName.removeClass('has-error');
	$formGroupSite.removeClass('has-error');
	$formGroupLocation.removeClass('has-error');
	$formGroupOpenTime.removeClass('has-error');
	$formGroupCloseTime.removeClass('has-error');
}

//Error text
var $errorDeviceName = $('#error_device_name');
var $errorSite = $('#error_site');
var $errorLocation = $('#error_location');
var $errorOpenTime = $('#error_open_time');
var $errorCloseTime = $('#error_close_time');
//Error forms
var $formGroupDeviceName = $('#form_group_device_name');
var $formGroupSite = $('#form_group_site');
var $formGroupLocation = $('#form_group_location');
var $formGroupOpenTime = $('#form_group_open_time');
var $formGroupCloseTime = $('#form_group_close_time');
//Modal
var $editDeviceModal = $('#editDeviceModal');

$formEditDevice.on('submit', function(e)
{
	e.preventDefault();
	var $this = $(this);

	$.ajax({
		url: $this.prop('action'),
		method: 'POST',
		data: $this.serialize(),
		success: function(data)
		{
			//Update the entire page using the current site
			var site_id = $currentSiteId.val();
			var myURL = '/dashboard/siteUpdate/' + site_id;
			updateDashboardData(myURL);

			//Close the edit device modal
			$editDeviceModal.modal('hide');
		},
		error: function(data){
			if (data.status === 422)
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
			}
		}
	});
});

//Update the site dropdown list
function updateSiteDropdown(sites)
{
	$siteList.empty();
	if (sites.length > 0)
	{
		var siteString = "";
		for (i = 0; i < sites.length; i++)
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
	if (locations.length > 0)
	{
		var locationString = "";
		for (i = 0; i < locations.length; i++)
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
	for (i = 0; i < devices.length; i++)
	{
		tableDevicesString += '<tr id="tr_' + devices[i]["id"] + '">' +
			'<td>' + devices[i]["name"] + '</td>' +
			'<td>' +
			'<div class="btn-group" role="group">' +
			'<button class="btn btn-primary" type="button" onclick="changeDevice(this);" id="btn_view_' + devices[i]["id"] + '"><i class="fa fa-video-camera"></i> View</button>' +
			'<button class="btn btn-primary btn-info" type="button"><i class="glyphicon glyphicon-resize-small"></i> Close</button>' +
			'<button class="btn btn-success" type="button" data-toggle="collapse" data-target="#graph_row_' + devices[i]["id"] + '"><i class="fa fa-line-chart"></i> Graphs</button>' +
			'<button class="btn btn-warning" type="button"><i class="glyphicon glyphicon-lock"></i> Disable</button>' +
			'<button class="btn btn-danger" type="button" data-toggle="modal" data-target="#editDeviceModal" onclick="updateDeviceModal(this);" id="btn_edit_' + devices[i]["id"] + '"><i class="glyphicon glyphicon-edit"></i> Edit</button>' +
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
			'<p><img class="img-responsive" src="https://smartsettia.com/img/temp-graph.png"></p>' +
			'</div>' +
			'<div class="tab-pane" role="tabpanel" id="tab_2_' + devices[i]["id"] + '">' +
			'<p><img class="img-responsive" src="https://smartsettia.com/img/humidity-graph.png"></p>' +
			'</div>' +
			'<div class="tab-pane" role="tabpanel" id="tab_3_' + devices[i]["id"] + '">' +
			'<p><img class="img-responsive" src="https://smartsettia.com/img/light-graph.png"></p>' +
			'</div>' +
			'</div>' +
			'</div>' +
			'</td>' +
			'</tr>'
	}
	$tableBody.append(tableDevicesString);
}

//Get the temperature amount as a formatted string
function getTemperature(val)
{
	var temperature;

	if (val == null)
		temperature = "C";
	else
		temperature = val + "C";

	return temperature;
}

//Get the humidity amount as a formatted string
function getHumidity(val)
{
	var humidity;

	if (val == null)
		humidity = "%";
	else
		humidity = val + "%";

	return humidity;
}

//Get the light amount as a formatted string
function getLight(val)
{
	var light;

	if (val == null)
		light = "%";
	else
		light = val + "%";

	return light;
}
