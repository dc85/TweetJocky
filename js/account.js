// JavaScript Document

var onTop = "TJsettings";

function changePane(paneName) {
	if(paneName == "TJhome") {
		$("#paneSettings").hide();
		$("#paneFaq").hide();
		$("#paneHome").show();
		onTop = "TJhome";
	} else if(paneName == "TJsettings") {
		$("#paneHome").hide();
		$("#paneFaq").hide();
		$("#paneSettings").show();
		onTop = "TJsettings";
	} else if(paneName == "TJfaq") {
		$("#paneHome").hide();
		$("#paneSettings").hide();
		$("#paneFaq").show();
		onTop = "TJfaq";
	}
}