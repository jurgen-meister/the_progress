$(document).ready(function(){
//START SCRIPT

	//Initialize dropdown lists to position 0 for firefox refresh bug
	$('#modules option:nth-child(1)').attr("selected", "selected");
	$('#controllers option:nth-child(1)').attr("selected", "selected");
    
	//Initialize AJAX
    $('#modules').change(function(){
        ajax_list_controllers();
		$("#message").hide();
    });

	function ajax_list_controllers(){
        $.ajax({
            type:"POST",
            url:urlModuleController + "ajax_list_controllers",
            data:{module: $('#modules').val()},
            beforeSend: showProcessing,
            success:showControllers
        });
    }
	
	function ajax_save(){
		$.ajax({
            type:"POST",
            url:urlModuleController + "ajax_save",
            data:{controller: captureCheckbox(), module: $("#modules").val() },
            beforeSend:showProcessing,
            success:showSave
        });
	}
	
	function showProcessing(){
        $("#processing").text("Procesando...");
    }
	
    function showControllers(data){
        $("#processing").text("");
        $("#boxControllers").html(data);
		fnBittionSetSelectsStyle();
    }
	
	function showSave(data){
		$("#processing").text("");
		$("#message").html(data);
	}
	
	function captureCheckbox(){
	 var allVals =[];
     $('form .checkbox :checked').each(function(){
       allVals.push($(this).val());});	   
	   return allVals;
	}

	
});

