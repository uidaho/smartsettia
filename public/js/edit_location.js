let $siteDropDown = $('#site');
let $siteTextBox = $('#new_site_name');

/*Retrieves the locations connected to the site or converts the drop down menus to text boxes
 *when a new site is being created
 */
$siteDropDown.change(function ()
{
	let site_id = $siteDropDown.val();

	//Check if the selected drop down element is the "Create new site" element
	if (site_id === '')
	{
		//Hide the drop downs and display the text boxes for site
		$siteDropDown.hide();
		$siteTextBox.show();
	}
});