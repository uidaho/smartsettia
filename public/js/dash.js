var $siteDropDown = $('#site');
var $locationDropDown = $('#location');

/*Retrieves the locations connected to the site or converts the drop down menus to text boxes
 *when a new site is being created
 */
$siteDropDown.change(function ()
{
	var site_id = $siteDropDown.val();

	//If the drop down menu for the location is hidden then reveal it and hide the text box
	if ($locationTextBox.is(':visible'))
	{
		$locationTextBox.hide();
		$locationDropDown.show();
		$locationTextBox.val('');
	}

	//Use ajax to get the locations attached to the selected site
	$.ajax({
		type: 'GET',
		url: '/device/' + site_id + '/locations',
		data: '',
		success: function(data)
		{
			$locationDropDown.empty();
			$.each(data, function(index, location)
			{
				$locationDropDown.append($("<option></option>").attr('value', location.id).text(location.name));
			});

			$locationDropDown.append($("<option></option>").attr('value', '').text('Create new location'));
		}
	});
});

var $headerDevice = $('#header_device');
var hiddenViewBtn;

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
			//Change the photo being loaded
			deviceImageURL = deviceImageURL.substring(0, deviceImageURL.lastIndexOf('/') + 1) + device_id;

			//Change the header for the device
			$headerDevice.html(data['name']);

			//Change the temperature value
			//$('#temperature').text(data['temperature'] + "C");

			//Change the humidity value
			//$('#humidity').text(data['humidity'] + "%");

			//Change the light value
			//$('#light').text(data['light_in'] + "%");

			//Hide the view button
			$(btn).css('visibility','hidden');
			hiddenViewBtn.css('visibility','visible');
			hiddenViewBtn = $(btn);
		}
	});

	//console.log(hiddenViewBtn);
}

var editDeviceID;
//Edit Device
function updateDeviceModal(btn)
{
	editDeviceID = btn.id.substring(btn.id.lastIndexOf('_') + 1);

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