/**
 * @ps array of player names
 * @mfs array of my features
 * @yfs array of your features
 * @fs array of features
 */
function getJohariWindows(ps, mfs, yfs, fs){
	var result = [];
	for(var i=0; i<ps.length; i++){
		var data = {};
		var mine = mfs[i];
		var fromOthers = yfs[i];
		data.name = ps[i];
		data.openWindow = getOpenWindow(mine, fromOthers);
		data.hiddenWindow = getHiddenWindow(mine, fromOthers);
		data.blindWindow = getBlindWindow(mine, fromOthers);
		data.unknownWindow = getUnknownWindow(mine, fromOthers, fs, features);
		result.push(data);
	}
	return result;
}

function getOpenWindow(mine, fromOthers){
	var result = [];
	for(var i=0; i<mine.length; i++){
		if(fromOthers.indexOf(mine[i]) > -1){
			result.push(mine[i]);
		}
	}
	return result;
}

function getHiddenWindow(mine, fromOthers){
	var result = [];
	for(var i=0; i<mine.length; i++){
		if(fromOthers.indexOf(mine[i]) == -1){
			result.push(mine[i]);
		}
	}
	return result;
}

function getBlindWindow(mine, fromOthers){
	var result = [];
	for(var i=0; i<fromOthers.length; i++){
		if(mine.indexOf(fromOthers[i]) == -1){
			result.push(fromOthers[i]);
		}
	}
	return result;			
}

function getUnknownWindow(mine, fromOthers, fs){
	var result = [];
	var known = mine.concat(fromOthers);
	for(var i=0; i<fs.length; i++){
		if(known.indexOf(i.toString()) == -1){
			result.push(i);
		}
	}
	return result;
}

function convertWinToElements(win, fs){
	var elm = "<div class='row'>";
	var numelm = 0;
	var temp = "";
	var lastone = "";
	var times = 0;
	var convertedFeatures = [];
	var numExtraBlank = 0;

	for(var i=0; i<fs.length; i++){
		if(lastone === fs[win[i]] || i == 0){
			times++;
			numExtraBlank++;
		}else{
			temp = times>1?lastone+" ×"+times:lastone;
			convertedFeatures.push(temp);
			// reset
			temp = "";
			times = 1;
		}
		lastone = fs[win[i]]?fs[win[i]]:"&nbsp;";
	}
	// process of the last
	temp = times>1?lastone+"×"+times:lastone;
	convertedFeatures.push(temp);

	for(var i=0; i<=numExtraBlank; i++){
		convertedFeatures.push("&nbsp;");
	}

	for(var i=0; i<convertedFeatures.length; i++){
		elm += "<div class='col-md-4 col-xs-6'>"+convertedFeatures[i]+"</div>";
		numelm++;
		if(numelm == 3){
			elm += "</div><div class='row'>";
			numelm = 0;
		}
	}
	elm += "</div>";
	return elm;
}

function showJohariWindow(johariWindows, fs){
	var result = $("#result");
	var openWindow;
	var openWindowElm = "";
	var hiddenWindow;
	var hiddenWindowElm = "";
	var blindWindow;
	var blindWindowElm = "";
	var unknownWindow;
	var unknownWindowElm = "";

	for(var i=0; i<johariWindows.length; i++){
		var johariWindow = johariWindows[i];
		result.append("<h3>" + johariWindow.name +"さんのジョハリの窓</h3>");
		result.append("<div class='row'><div class='col-md-6 col-xs-6'><div class='alert alert-danger' id='open_" + i + "'><h4>開放の窓</h4></div></div><div class='col-md-6 col-xs-6'><div class='alert alert-success' id='blind_" + i + "'><h4>盲点の窓</h4></div></div></div><div class='row'><div class='col-md-6 col-xs-6'><div class='alert alert-warning' id='hidden_" + i + "'><h4>秘密の窓</h4></div></div><div class='col-md-6 col-xs-6'><div class='alert alert-info' id='unknown_"+ i +"'><h4>未知の窓</h4></div></div></div>");
		// open window
		$("#open_" + i).append(convertWinToElements(johariWindow.openWindow, fs));

		// hidden window
		$("#hidden_" + i).append(convertWinToElements(johariWindow.hiddenWindow, fs));

		// blind window
		$("#blind_" + i).append(convertWinToElements(johariWindow.blindWindow, fs));

		// unknown window
		$("#unknown_" + i).append(convertWinToElements(johariWindow.unknownWindow, fs));
		result.append("<hr/>");
		result.append("<div style='page-break-before:always'>"); //page break for printout
	}
}

function getMaxCheckableNumber(ps, fs){
	var numOfFeatures = fs.length;
	var numOfPlayers = ps.length;
	return Math.ceil((numOfFeatures / 1.5)) - (numOfPlayers - 1);
}

function isCheckableNum(player, ps, fs){
	return $("[name='features_" + player + "']:checked").length <= getMaxCheckableNumber(ps, fs);
}