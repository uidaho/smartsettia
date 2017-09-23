var $headerSite = $('#header_site');
var $headerLocation = $('#header_location');
var $headerDevice = $('#header_device');
var $tableBody = $('#device_table tbody');
var $tempNum = $('#temperature');
var $humidityNum = $('#humidity');
var $lightNum = $('#light');
var $site_change = $("#site_change li");
var $location_change = $("#location_change li");
var hiddenViewBtn;

//Change Site
$site_change.click(function()
{
	var site_id = $(this).val();

	//
	$.ajax({
		type: 'GET',
		url: '/dashboard/siteUpdate/' + site_id,
		data: '',
		success: function(data)
		{
			//console.log(data['devices']);
			//console.log(data['locations']);
			//console.log(data['sites']);

			//Change the site and location names
			$headerSite.html(data['default_device']['site_name']);
			$headerLocation.html(data['default_device']['location_name']);

			//Empty the device table's body
			$tableBody.empty();
			var tableDevicesString = "";
			//Add the devices to the table
			$.each(data['devices'], function(index, device)
			{
				//TODO update the graphs with correct urls
				tableDevicesString += '<tr id="tr_' + device["id"] + '">' +
										'<td>' + device["name"] + '</td>' +
											'<td>' +
												'<div class="btn-group" role="group">' +
													'<button class="btn btn-primary" type="button" onclick="changeDevice(this);" id="btn_view_' + device["id"] + '"><i class="fa fa-video-camera"></i> View</button>' +
													'<button class="btn btn-primary btn-info" type="button"><i class="glyphicon glyphicon-resize-small"></i> Close</button>' +
													'<button class="btn btn-success" type="button" data-toggle="collapse" data-target="#graph_row_' + device["id"] + '"><i class="fa fa-line-chart"></i> Graphs</button>' +
													'<button class="btn btn-warning" type="button"><i class="glyphicon glyphicon-lock"></i> Disable</button>' +
													'<button class="btn btn-danger" type="button" data-toggle="modal" data-target="#editDeviceModal" onclick="updateDeviceModal(this);" id="btn_edit_' + device["id"] + '"><i class="glyphicon glyphicon-edit"></i> Edit</button>' +
												'</div>' +
											'</td>' +
									'</tr>' +
									'<tr class="collapse" id="graph_row_' + device['id'] + '">' +
										'<td colspan="2">' +
											'<div>' +
												'<ul class="nav nav-tabs">' +
													'<li class="active"><a href="#tab_1_' + device["id"] + '" role="tab" data-toggle="tab"><i class="fa fa-thermometer-empty"></i> Temp <span class="badge">' + getTemperature(device['temperature']) + '</span></a></li>' +
													'<li><a href="#tab_2_' + device["id"] + '" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-tint"></i> RH <span class="badge">' + getHumidity(device['humidity']) + '</span></a></li>' +
													'<li><a href="#tab_3_' + device["id"] + '" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-adjust"></i> Light <span class="badge">' + getHumidity(device['light_in']) + '</span></a></li>' +
												'</ul>' +
												'<div class="tab-content">' +
													'<div class="tab-pane active" role="tabpanel" id="tab_1_' + device["id"] + '">' +
														'<p><img class="img-responsive" src="http://localhost:8000/img/temp-graph.png"></p>' +
													'</div>' +
													'<div class="tab-pane" role="tabpanel" id="tab_2_' + device["id"] + '">' +
														'<p><img class="img-responsive" src="http://localhost:8000/img/humidity-graph.png"></p>' +
													'</div>' +
													'<div class="tab-pane" role="tabpanel" id="tab_3_' + device["id"] + '">' +
														'<p><img class="img-responsive" src="http://localhost:8000/img/light-graph.png"></p>' +
													'</div>' +
												'</div>' +
											'</div>' +
										'</td>' +
									'</tr>'

			});
			$tableBody.append(tableDevicesString);

			//Hide the view button of the active device
			hideFirstViewBtn();

			//Set the device image url, sensor values, and the device header name
			updateActiveDeviceInfo(data['default_device']['id'], data['default_device']);
		}
	});
});

//Change Site
$location_change.click(function()
{
	var location_id = $(this).val();

	//
	$.ajax({
		type: 'GET',
		url: '/dashboard/locationUpdate/' + location_id + '/' + site_id,
		data: '',
		success: function(data)
		{
			//console.log(data['devices']);
			//console.log(data['locations']);
			//console.log(data['sites']);

			//Change the site and location names
			$headerSite.html(data['default_device']['site_name']);
			$headerLocation.html(data['default_device']['location_name']);

			//Empty the device table's body
			$tableBody.empty();
			var tableDevicesString = "";
			//Add the devices to the table
			$.each(data['devices'], function(index, device)
			{
				//TODO update the graphs with correct urls
				tableDevicesString += '<tr id="tr_' + device["id"] + '">' +
					'<td>' + device["name"] + '</td>' +
					'<td>' +
					'<div class="btn-group" role="group">' +
					'<button class="btn btn-primary" type="button" onclick="changeDevice(this);" id="btn_view_' + device["id"] + '"><i class="fa fa-video-camera"></i> View</button>' +
					'<button class="btn btn-primary btn-info" type="button"><i class="glyphicon glyphicon-resize-small"></i> Close</button>' +
					'<button class="btn btn-success" type="button" data-toggle="collapse" data-target="#graph_row_' + device["id"] + '"><i class="fa fa-line-chart"></i> Graphs</button>' +
					'<button class="btn btn-warning" type="button"><i class="glyphicon glyphicon-lock"></i> Disable</button>' +
					'<button class="btn btn-danger" type="button" data-toggle="modal" data-target="#editDeviceModal" onclick="updateDeviceModal(this);" id="btn_edit_' + device["id"] + '"><i class="glyphicon glyphicon-edit"></i> Edit</button>' +
					'</div>' +
					'</td>' +
					'</tr>' +
					'<tr class="collapse" id="graph_row_' + device['id'] + '">' +
					'<td colspan="2">' +
					'<div>' +
					'<ul class="nav nav-tabs">' +
					'<li class="active"><a href="#tab_1_' + device["id"] + '" role="tab" data-toggle="tab"><i class="fa fa-thermometer-empty"></i> Temp <span class="badge">' + getTemperature(device['temperature']) + '</span></a></li>' +
					'<li><a href="#tab_2_' + device["id"] + '" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-tint"></i> RH <span class="badge">' + getHumidity(device['humidity']) + '</span></a></li>' +
					'<li><a href="#tab_3_' + device["id"] + '" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-adjust"></i> Light <span class="badge">' + getHumidity(device['light_in']) + '</span></a></li>' +
					'</ul>' +
					'<div class="tab-content">' +
					'<div class="tab-pane active" role="tabpanel" id="tab_1_' + device["id"] + '">' +
					'<p><img class="img-responsive" src="http://localhost:8000/img/temp-graph.png"></p>' +
					'</div>' +
					'<div class="tab-pane" role="tabpanel" id="tab_2_' + device["id"] + '">' +
					'<p><img class="img-responsive" src="http://localhost:8000/img/humidity-graph.png"></p>' +
					'</div>' +
					'<div class="tab-pane" role="tabpanel" id="tab_3_' + device["id"] + '">' +
					'<p><img class="img-responsive" src="http://localhost:8000/img/light-graph.png"></p>' +
					'</div>' +
					'</div>' +
					'</div>' +
					'</td>' +
					'</tr>'

			});
			$tableBody.append(tableDevicesString);

			//Hide the view button of the active device
			hideFirstViewBtn();

			//Set the device image url, sensor values, and the device header name
			updateActiveDeviceInfo(data['default_device']['id'], data['default_device']);
		}
	});
});

function hideFirstViewBtn()
{
	var tr_id = $('#device_table tr').eq(1).attr('id');
	var device_id = tr_id.substring(tr_id.indexOf('_') + 1);
	hiddenViewBtn = $('#btn_view_' + device_id);
	hiddenViewBtn.css('visibility','hidden');
}
hideFirstViewBtn();


function changeDevice(btn)
{
	var device_id = btn.id.substring(btn.id.lastIndexOf('_') + 1);

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
	console.log(device_id);

	//Change the header for the device
	$headerDevice.html(data['name']);

	//Change the temperature value
	$tempNum.text(getTemperature(data['temperature']));

	//Change the humidity value
	$humidityNum.text(getHumidity(data['humidity']));

	//Change the light value
	$lightNum.text(getLight(data['light_in']));
}

//Edit Device
function updateDeviceModal(btn)
{
	var editDeviceID = btn.id.substring(btn.id.lastIndexOf('_') + 1);

	//TODO update url with live websites
	//Update form route
	$('#form_edit_device').attr('action', 'http://localhost:8000/device/' + editDeviceID);

	$.ajax({
		type: 'GET',
		url: '/device/' + editDeviceID + '/details',
		data: '',
		success: function(data)
		{
			//Update input box for the device name
			$('#input_device_name').val(data['name']);

			//TODO update schedule
		}
	});
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
