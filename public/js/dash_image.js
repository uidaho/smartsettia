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



/*
*This is for demoing and should be removed once live images are active
*TODO remove
 */
var myVideo = document.getElementById("video1");
var mainButton = document.getElementById("mainButton");
var secondaryButton = document.getElementById("secondaryButton");
var currentType = "Close";
var lastType = "Open";

//Detect time of video
var interval = setInterval(checkTime, 100);
function checkTime()
{
	if(Math.floor(myVideo.currentTime) == 18){
		//clearInterval(interval);
		myVideo.pause();
		myVideo.currentTime = 19;
		var temp = currentType;
		currentType = lastType;
		lastType = temp;
		mainButton.innerHTML = "<i class='glyphicon glyphicon-resize-full'></i> " + currentType;
		secondaryButton.innerHTML = "<i class='glyphicon glyphicon-resize-full'></i> " + currentType;
	}
	else if(Math.floor(myVideo.currentTime) == 37){
		//clearInterval(interval);
		myVideo.pause();
		myVideo.currentTime = 0;
		var temp = currentType;
		currentType = lastType;
		lastType = temp;
		mainButton.innerHTML = "<i class='glyphicon glyphicon-resize-full'></i> " + currentType;
		secondaryButton.innerHTML = "<i class='glyphicon glyphicon-resize-full'></i> " + currentType;
	}
}

// Detect video finished
//document.getElementById('video1').addEventListener('ended', openFinished, false);
function openFinished(e)
{
	mainButton.innerHTML = "<i class='glyphicon glyphicon-resize-full'></i> " + currentType;
}

//Play and pause commands
function playPause()
{
	if (myVideo.paused)
	{
		myVideo.play();
		mainButton.innerHTML = "<i class='glyphicon glyphicon glyphicon-stop'></i> Stop";
		secondaryButton.innerHTML = "<i class='glyphicon glyphicon glyphicon-stop'></i> Stop";
	}
	else
	{
		myVideo.pause();
		mainButton.innerHTML = "<i class='glyphicon glyphicon-resize-small'></i> " + currentType;
		secondaryButton.innerHTML = "<i class='glyphicon glyphicon-resize-small'></i> " + currentType;
	}
}