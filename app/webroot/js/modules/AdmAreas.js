$(document).ready(function(){
//START SCRIPT

	function ajax_list_periods_areas(){
	    $.ajax({ 
            type:"POST",
            url:urlModuleController + "ajax_list_periods_areas",			
            data:{period: $("#cbxPeriods").val()},
            //beforeSend: showProcessing,
            success: function(data){
				 $("#boxParentAreas").html(data);
				 fnBittionSetSelectsStyle();
			},
			error: function(data){
				$.gritter.add({
					title:	'OCURRIO UN PROBLEMA!',
					text:	'Vuelva a intentarlo',
					sticky: false,
					image:urlImg+'error.png'
				});		
			}
        });
   }

	$('#cbxPeriods').change(function(){
		ajax_list_periods_areas();
	});

//END SCRIPT	
});

