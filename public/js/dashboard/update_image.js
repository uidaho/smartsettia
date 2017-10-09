//Image Modal
var $modalImage = $('#image_modal img');
var $imageCaption = $('#image_caption');
//Image Refresher
var keepRefreshingImage = true;
var deviceImage = document.getElementById("deviceImage");	//The element for the device image
var deviceImageURL = deviceImage.src;						//The url for getting the image
var $downloadImageLink = $('#download_image_link');

//Refresh device image after a set amount of time
//1000 = 1 second
function refreshImage()
{
	updateDeviceImage();

	if (keepRefreshingImage)
		imageUpdateTimeout = setTimeout("refreshImage();", imageUpdateRate)
}
refreshImage();

//Update the device image url with the date to prevent the browser from caching
function updateDeviceImage()
{
	var newImage = deviceImageURL + "?" + Date.now();
	deviceImage.src = newImage;
	$downloadImageLink.attr('href', newImage);
	$modalImage.attr('src', newImage);
}