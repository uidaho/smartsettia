var $siteDropDown = $('#site');
var $siteTextBox = $('#new_site_name');
var $locationDropDown = $('#location');
var $locationTextBox = $('#new_location_name');
var firstSelection = true;

/*Retrieves the locations connected to the site or converts the drop down menus to text boxes
 *when a new site is being created
 */
$siteDropDown.change(function ()
{
	if (firstSelection)
	{
		$("#site option[value='-1']").remove();
		firstSelection = false;
	}

	var site_id = $siteDropDown.val();

	//Check if the selected drop down element is the "Create new location" element
	if (site_id === '')
	{
		//Hide the drop downs and display the text boxes for both site and location
		$siteDropDown.hide();
		$siteTextBox.show();
		$locationDropDown.hide();
		$locationTextBox.show();
	}
	else
	{
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
	}
});