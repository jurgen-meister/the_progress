//$(document).ready(function() { //With this uncommented doesn't work globally
//START SCRIPT

//Check url's action and controller
var urlHost = window.location.host;
var urlPathName = window.location.pathname;
var urlPaths = urlPathName.split('/');

var urlModuleController = '';
var urlAction = '';
var urlActionValue1 = '';

var urlControllerClean = '';
var urlImg = '';
if (urlHost.toUpperCase() === 'LOCALHOST' || urlHost === '127.0.0.1') { //check if local or remote
	urlControllerClean = urlPaths[2];
	urlImg = '/'+urlPaths[1]+'/img/';
	
	urlModuleController = '/' + urlPaths[1] + '/' + urlPaths[2] + '/';
	urlAction = urlPaths[3];
	urlActionValue1 = urlPaths[4];
} else {
	urlControllerClean = urlPaths[1];
	urlImg = '/img/';
	
	urlModuleController = '/' + urlPaths[1] + '/';
	urlAction = urlPaths[2];
	urlActionValue1 = urlPaths[3];
}

var globalPeriod = $('#globalPeriod').text();//Check Current Period for validation


//***********************START - Execute MAIN*****************************//
fnBittionSetSelectsStyle();
fnBittionSetTypeDate();
//***********************END - Execute MAIN*****************************//


//Wrap every select control with select2() plugin, if select created dynamically still needs to be binded on a success ajax call
function fnBittionSetSelectsStyle() {
	if ($('#currentDeviceType').text() === 'computer') {
		$('select').select2();
	}
}

function fnBittionSetTypeDate() {
	$('.input-date-type').prop('type', 'text');
	$('.input-date-type').datepicker({showButtonPanel: true});
	$('.input-date-type-months').datepicker({showButtonPanel: true, viewMode: "months"});
	$('.input-date-type-years').datepicker({showButtonPanel: true, viewMode: "years"});
	$('.input-date-type, .input-date-type-months, .input-date-type-years').keydown(function(event) {
		event.preventDefault();
	});
}



//'class'=>'input-date-type' 
//END SCRIPT	
//});

