$(document).ready(function(){
	///Url Paths
//	var path = window.location.pathname;
//	var arr = path.split('/');
//	var moduleController = ('/'+arr[1]+'/'+arr[2]+'/');//Path validation
//
//	//Calendar script
//   $("#txtDate").datepicker({
//	  showButtonPanel: true
//   });
//   
//   $('#txtDate').keydown(function(e){e.preventDefault();});
//   
   $("#btnClearSearch").click(function(event){
	  //return false; 
	  $('#txtDate').val("");
	  if ($('#txtNoteCode').length > 0){//existe
		  $('#txtNoteCode').val("");
	  }
	  event.preventDefault();
   });
	
//END SCRIPT	
});