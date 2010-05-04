// JavaScript Document

var onTop = "TJsettings";
var eleList = new Array("apiKey","aCycle","sDefault","tEnt","tNews","tBus","tMusic","tTech","tHealth","rUSAw","rUSAc","rUSAe","rCANw","rCANc","rCANe");

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

function saveSettings() {
	for(var i=0; i<= eleList.length; i++) {
		ele = document.getElementById(eleList[i]);
		if(ele.type = "checkbox") {
			
		} else if(ele.type = "text") {
			
		} else if(ele.type = "select-one") {
			
		}
	}
}