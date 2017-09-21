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