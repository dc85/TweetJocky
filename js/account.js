// JavaScript Document

var onTop = "TJsettings";
var eleList = new Array('','','','','','','','','');

function changePane(paneName) {
	if(paneName == "TJhome") {
		$("#paneSettings").hide();
		$("#paneFaq").hide();
		$("#paneTweets").hide();
		$("#paneHome").show();
		onTop = "TJhome";
	} else if(paneName == "TJtweets") {
		$("#paneHome").hide();
		$("#paneSettings").hide();
		$("#paneFaq").hide();
		$("#paneTweets").show();
		onTop = "TJtweets";
	} else if(paneName == "TJsettings") {
		$("#paneHome").hide();
		$("#paneFaq").hide();
		$("#paneTweets").hide();
		$("#paneSettings").show();
		onTop = "TJsettings";
	} else if(paneName == "TJfaq") {
		$("#paneHome").hide();
		$("#paneSettings").hide();
		$("#paneTweets").hide();
		$("#paneFaq").show();
		onTop = "TJfaq";
	}
}

function saveSettings() {

}