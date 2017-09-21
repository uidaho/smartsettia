var keepRefreshing = true;
var deviceImage = document.getElementById("deviceImage");						//The element for the device image
var deviceImageURL = deviceImage.src;											//The url for getting the image
//deviceImageURL = deviceImageURL.substr(0, deviceImageURL.lastIndexOf("/"));		//Remove everything following the last /

//Refresh device image after a set amount of time
//1000 = 1 second
function refreshImage()
{
	deviceImage.src = deviceImageURL + "?" + Date.now();
	if (keepRefreshing)
		setTimeout("refreshImage();", 60000)
}
refreshImage();