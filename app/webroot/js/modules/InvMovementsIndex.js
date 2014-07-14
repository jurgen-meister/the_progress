$(document).ready(function(){
//START SCRIPT
  
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