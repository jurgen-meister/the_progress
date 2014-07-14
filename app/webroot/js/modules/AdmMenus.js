$(document).ready(function(){
//START SCRIPT
	
	//Initialize AJAX
    $('#modules').change(function(){
        ajax_list_actions_out();		
    });
	
	$('#modules_inside').change(function(){
        ajax_list_controllers_inside();		
    });
	
	$('#controllers').change(function(){
        ajax_list_actions_inside();		
    });
	
	$('#cbxSearchModules').change(function(){
		$('#formAdmMenuIndexOut').submit();
	});
	
	function ajax_list_actions_out(){
        $.ajax({
            type:"POST",
            url:urlModuleController + "ajax_list_actions_out",			
            data:{module: $("#modules").val(), action:$("#cbxAction").val()},
            beforeSend: showProcessing,
            success: showActions
        });
    }
	
	function ajax_list_controllers_inside(){
        $.ajax({
            type:"POST",
            url:urlModuleController + "ajax_list_controllers_inside",			
            data:{module: $("#modules_inside").val()},
            beforeSend: showProcessing,
            //success: showControllersInside
			success:function(data){
				showControllersInside(data);
				$('#controllers').bind("change",function(){
					 ajax_list_actions_inside();
				});
			}
        });
    }
	
	function ajax_list_actions_inside(){
        $.ajax({
            type:"POST",
            url:urlModuleController + "ajax_list_actions_inside",			
            data:{controller: $("#controllers").val()},
            beforeSend: showProcessing,
            success: showActionsInside
        });
    }
	
	function showProcessing(){
        $("#processing").text("Procesando...");
    }
    function showActions(data){
        $("#processing").text("");
        $("#boxActions").html(data);
		$('select').select2();
    }
	function showControllersInside(data){
        $("#processing").text("");
        $("#boxControllers").html(data);
    }
	function showActionsInside(data){
        $("#processing").text("");
        $("#boxActions").html(data);
    }
	
});